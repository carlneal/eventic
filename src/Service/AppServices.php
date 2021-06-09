<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelInterface;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\OrderElement;
use App\Entity\OrderTicket;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class AppServices {

    private $em;
    private $authChecker;
    private $requestStack;
    private $kernel;
    private $cache;
    private $router;
    private $security;
    private $mailer;
    private $translator;
    private $params;
    private $templating;
    private $urlMatcherInterface;

    public function __construct(EntityManagerInterface $entityManager, AuthorizationCheckerInterface $authChecker, RequestStack $requestStack, KernelInterface $kernel, AdapterInterface $cache, UrlGeneratorInterface $router, Security $security, \Swift_Mailer $mailer, TranslatorInterface $translator, ParameterBagInterface $params, \Twig_Environment $templating, UrlMatcherInterface $urlMatcherInterface) {
        $this->em = $entityManager;
        $this->authChecker = $authChecker;
        $this->requestStack = $requestStack;
        $this->kernel = $kernel;
        $this->cache = $cache;
        $this->router = $router;
        $this->security = $security;
        $this->mailer = $mailer;
        $this->translator = $translator;
        $this->params = $params;
        $this->templating = $templating;
        $this->urlMatcherInterface = $urlMatcherInterface;
    }

    // Redirects to the referer page when available, if not, redirects to the dashboard index
    public function redirectToReferer($alt = null) {
        if ($this->requestStack->getCurrentRequest()->headers->get('referer')) {
            return new RedirectResponse($this->requestStack->getCurrentRequest()->headers->get('referer'));
        } else {
            if ($alt) {
                if ($this->authChecker->isGranted('ROLE_ADMINISTRATOR')) {
                    return new RedirectResponse($this->router->generate('dashboard_administrator_' . $alt));
                } elseif ($this->authChecker->isGranted('ROLE_ORGANIZER')) {
                    return new RedirectResponse($this->router->generate('dashboard_organizer_' . $alt));
                } elseif ($this->authChecker->isGranted('ROLE_ATTENDEE')) {
                    return new RedirectResponse($this->router->generate('dashboard_attendee_' . $alt));
                } elseif ($this->authChecker->isGranted('ROLE_POINTOFSALE')) {
                    return new RedirectResponse($this->router->generate('dashboard_pointofsale_' . $alt));
                } else {
                    return new RedirectResponse($this->router->generate($alt));
                }
            } else {
                return new RedirectResponse($this->router->generate('dashboard_index'));
            }
        }
    }

    // Generates a random string iwth a specified length
    public function generateReference($length) {
        $reference = implode('', [
            bin2hex(random_bytes(2)),
            bin2hex(random_bytes(2)),
            bin2hex(chr((ord(random_bytes(1)) & 0x0F) | 0x40)) . bin2hex(random_bytes(1)),
            bin2hex(chr((ord(random_bytes(1)) & 0x3F) | 0x80)) . bin2hex(random_bytes(1)),
            bin2hex(random_bytes(2))
        ]);

        return strlen($reference) > $length ? substr($reference, 0, $length) : $reference;
    }

    // Returns the current user location
    public function locateUser() {
        $request = $this->requestStack->getCurrentRequest();
        $reader = new Reader($this->kernel->getProjectDir() . "/assets/vendor/geolite/GeoLite2-City.mmdb");
        try {
            $ip = '128.101.101.101';
            if ($this->kernel->getEnvironment() == "prod") {
                $ip = $request->getClientIp();
            }
            $record = $reader->city($ip);
            $countryentity = $this->getCountries(array('isocode' => $record->country->isoCode))->getQuery()->getOneOrNullResult();
        } catch (AddressNotFoundException $ex) {
            return null;
            //return new Response($this->translator->trans("It wasn't possible to retrieve information about the provided IP"));
        }

        return array('record' => $record, 'country' => $countryentity);
    }

    // Gets a setting from the cache / db
    public function getSetting($key) {

        $settingcache = $this->cache->getItem('settings_' . $key);
        if ($settingcache->isHit()) {
            return $settingcache->get();
        }
        $setting = $this->em->getRepository('App\Entity\Settings')->findOneByKey($key);

        if (!$setting) {
            return null;
        }

        $settingcache->set($setting->getValue());
        $this->cache->save($settingcache);
        return ($setting ? ($setting->getValue()) : ( null));
    }

    // Sets a setting from the cache / db
    public function setSetting($key, $value) {
        $setting = $this->em->getRepository('App\Entity\Settings')->findOneByKey($key);
        if ($setting) {
            $setting->setValue($value);
            $this->em->flush();
            $settingcache = $this->cache->getItem('settings_' . $key);
            $settingcache->set($value);
            $this->cache->save($settingcache);

            if ($key == "website_name" || $key == "no_reply_email" || $key == "website_root_url") {
                $this->updateEnv(strtoupper($key), $value);
            }

            return 1;
        } else {
            return 0;
        }
    }

    // Updates the .env key with the choosen value
    function updateEnv($key, $value) {
        if (strlen($key) == 0) {
            return;
        }

        $envFile = $this->kernel->getProjectDir() . '/.env';
        $lines = file($envFile);
        $newLines = [];
        foreach ($lines as $line) {
            preg_match('/' . $key . '=/i', $line, $matches);
            if (!count($matches)) {
                $newLines[] = $line;
                continue;
            }
            $newLine = trim($key) . "=" . trim($value) . "\n";
            $newLines[] = $newLine;
        }
        $newContent = implode('', $newLines);
        file_put_contents($envFile, $newContent);
    }

    // Gets the value with the entered key from the .env file
    function getEnv($key) {
        if (strlen($key) == 0) {
            return;
        }
        $envFile = $this->kernel->getProjectDir() . '/.env';
        $lines = file($envFile);
        foreach ($lines as $line) {
            preg_match('/' . $key . '=/i', $line, $matches);

            if (!count($matches)) {
                continue;
            }
            return trim(explode("=", $line, 2)[1]);
        }
        return null;
    }

    // Removes all the specified user cart elements
    public function emptyCart($user) {
        foreach ($user->getCartelements() as $cartelement) {
            $this->em->remove($cartelement);
        }
        $this->em->flush();
    }

    // Transforms the specified user cart into an order based on the application's logic
    public function transformCartIntoOrder(User $user) {
        $order = new Order();
        $order->setUser($user);
        $order->setReference($this->generateReference(15));
        $order->setStatus(0);
        foreach ($user->getCartelements() as $cartelement) {
            // Creates as many order elements as cart elements
            $orderelement = new OrderElement();
            $orderelement->setOrder($order);
            $orderelement->setEventticket($cartelement->getEventticket());
            $orderelement->setUnitprice($cartelement->getEventticket()->getSalePrice());
            $orderelement->setQuantity($cartelement->getQuantity());
            $order->addOrderelement($orderelement);
        }
        if ($user->hasRole("ROLE_ATTENDEE")) {
            $order->setTicketFee($this->getSetting("ticket_fee_online"));
            $order->setTicketPricePercentageCut($this->getSetting("online_ticket_price_percentage_cut"));
        } else if ($user->hasRole("ROLE_POINTOFSALE")) {
            $order->setTicketFee($this->getSetting("ticket_fee_pos"));
            $order->setTicketPricePercentageCut($this->getSetting("pos_ticket_price_percentage_cut"));
        }
        $order->setCurrencyCcy($this->getSetting("currency_ccy"));
        $order->setCurrencySymbol($this->getSetting("currency_symbol"));
        return $order;
    }

    // Handles all the operations needed after a successful payment processing
    public function handleSuccessfulPayment($orderReference) {
        $order = $this->getOrders(array('status' => 0, 'reference' => $orderReference))->getQuery()->getOneOrNullResult();
        $order->setStatus(1);
        foreach ($order->getOrderElements() as $orderelement) {
            for ($i = 1; $i <= $orderelement->getQuantity(); $i++) {
                $ticket = new OrderTicket();
                $ticket->setOrderElement($orderelement);
                $ticket->setReference($this->generateReference(20));
                $ticket->setScanned(false);
                $this->em->persist($ticket);
            }
        }
        $this->em->persist($order);
        $this->em->flush();
        if ($order->getUser()->hasRole("ROLE_ATTENDEE")) {
            $this->sendOrderConfirmationEmail($order, $order->getPayment()->getClientEmail());
        }
    }

    // Sends the tickets to the attendee
    public function sendOrderConfirmationEmail($order, $emailTo) {
        $pdfOptions = new Options();
        //$pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->templating->render('Dashboard/Shared/Order/ticket-pdf.html.twig', [
            'order' => $order,
            'eventDateTicketReference' => 'all'
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $ticketsPdfFile = $dompdf->output();

        $email = (new \Swift_Message($this->translator->trans('Your tickets bought from') . ' ' . $this->getSetting('website_name')))
                ->setFrom($this->getSetting('no_reply_email'))
                ->setTo($emailTo)
                ->setBody(
                        $this->templating->render('Dashboard/Shared/Order/confirmation-email.html.twig', ['order' => $order]), 'text/html')
                ->attach(new \Swift_Attachment($ticketsPdfFile, $order->getReference() . "-" . $this->translator->trans("tickets") . '.pdf', 'application/pdf'));

        $this->mailer->send($email);
        return 1;
    }

    // Handles all the operations needed after a failed payment processing
    public function handleFailedPayment($orderReference, $note = null) {
        $order = $this->getOrders(array('status' => 0, 'reference' => $orderReference))->getQuery()->getOneOrNullResult();
        $order->setStatus(-2);
        $order->setNote($note);
        $this->em->persist($order);
        $this->em->flush();
    }

    // Handles all the operations needed after a canceled payment processing
    public function handleCanceledPayment($orderReference, $note = null) {
        $order = $this->getOrders(array('status' => 'all', 'reference' => $orderReference))->getQuery()->getOneOrNullResult();
        foreach ($order->getOrderelements() as $orderElement) {
            foreach ($orderElement->getTicketsReservations() as $ticketReservation) {
                $this->em->remove($ticketReservation);
                $this->em->flush();
            }
        }
        $order->setStatus(-1);
        $order->setNote($note);
        $this->em->persist($order);
        $this->em->flush();
    }

    // Shows the soft deleted entities for ROLE_ADMINISTRATOR
    public function disableSofDeleteFilterForAdmin($entityManager, $authChecker) {
        $entityManager->getFilters()->enable('softdeleteable');
        if ($authChecker->isGranted("ROLE_ADMINISTRATOR")) {
            $entityManager->getFilters()->disable('softdeleteable');
        }
    }

    // Returns the categories after applying the specified search criterias
    public function getCategories($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $featured = array_key_exists('featured', $criterias) ? $criterias['featured'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "translations.name";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "ASC";

        return $this->em->getRepository("App\Entity\Category")->getCategories($hidden, $keyword, $slug, $featured, $limit, $sort, $order);
    }

    // Returns the countries after applying the specified search criterias
    public function getCountries($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $id = array_key_exists('id', $criterias) ? $criterias['id'] : "all";
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $isocode = array_key_exists('isocode', $criterias) ? $criterias['isocode'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "translations.name";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "ASC";

        return $this->em->getRepository("App\Entity\Country")->getCountries($id, $hidden, $keyword, $isocode, $slug, $limit, $sort, $order);
    }

    // Returns the languages after applying the specified search criterias
    public function getLanguages($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "translations.name";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "ASC";

        return $this->em->getRepository("App\Entity\Language")->getLanguages($hidden, $keyword, $slug, $limit, $sort, $order);
    }

    // Returns the audiences after applying the specified search criterias
    public function getAudiences($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "translations.name";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "ASC";

        return $this->em->getRepository("App\Entity\Audience")->getAudiences($hidden, $keyword, $slug, $limit, $sort, $order);
    }

    // Returns the venues types after applying the specified search criterias
    public function getVenuesTypes($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "translations.name";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "ASC";
        $hasvenues = array_key_exists('hasvenues', $criterias) ? $criterias['hasvenues'] : "all";
        return $this->em->getRepository("App\Entity\VenueType")->getVenuesTypes($hidden, $keyword, $slug, $limit, $sort, $order, $hasvenues);
    }

    // Returns the amenities after applying the specified search criterias
    public function getAmenities($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "translations.name";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "ASC";

        return $this->em->getRepository("App\Entity\Amenity")->getAmenities($hidden, $keyword, $slug, $limit, $sort, $order);
    }

    // Returns the venues after applying the specified search criterias
    public function getVenues($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $organizer = array_key_exists('organizer', $criterias) ? $criterias['organizer'] : "all";
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $country = array_key_exists('country', $criterias) ? $criterias['country'] : "all";
        $venuetypes = array_key_exists('venuetypes', $criterias) ? $criterias['venuetypes'] : "all";
        $directory = array_key_exists('directory', $criterias) ? $criterias['directory'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $count = array_key_exists('count', $criterias) ? $criterias['count'] : false;
        $minseatedguests = array_key_exists('minseatedguests', $criterias) ? $criterias['minseatedguests'] : "all";
        $maxseatedguests = array_key_exists('maxseatedguests', $criterias) ? $criterias['maxseatedguests'] : "all";
        $minstandingguests = array_key_exists('minstandingguests', $criterias) ? $criterias['minstandingguests'] : "all";
        $maxstandingguests = array_key_exists('maxstandingguests', $criterias) ? $criterias['maxstandingguests'] : "all";
        $organizerEnabled = array_key_exists('organizerEnabled', $criterias) ? $criterias['organizerEnabled'] : true;

        return $this->em->getRepository("App\Entity\Venue")->getVenues($organizer, $hidden, $keyword, $country, $venuetypes, $directory, $slug, $limit, $minseatedguests, $maxseatedguests, $minstandingguests, $maxstandingguests, $count, $organizerEnabled);
    }

    // Returns the events after applying the specified search criterias
    public function getEvents($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $category = array_key_exists('category', $criterias) ? $criterias['category'] : "all";
        $venue = array_key_exists('venue', $criterias) ? $criterias['venue'] : "all";
        $country = array_key_exists('country', $criterias) ? $criterias['country'] : "all";
        $organizer = array_key_exists('organizer', $criterias) ? $criterias['organizer'] : "all";
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $freeonly = array_key_exists('freeonly', $criterias) ? $criterias['freeonly'] : false;
        $onlineonly = array_key_exists('onlineonly', $criterias) ? $criterias['onlineonly'] : false;
        $pricemin = array_key_exists('pricemin', $criterias) ? $criterias['pricemin'] : "all";
        $pricemax = array_key_exists('pricemax', $criterias) ? $criterias['pricemax'] : "all";
        $audience = array_key_exists('audience', $criterias) ? $criterias['audience'] : "all";
        $startdate = array_key_exists('startdate', $criterias) ? $criterias['startdate'] : "all";
        $startdatemin = array_key_exists('startdatemin', $criterias) ? $criterias['startdatemin'] : "all";
        $startdatemax = array_key_exists('startdatemax', $criterias) ? $criterias['startdatemax'] : "all";
        if ($startdate == "today") {
            $startdate = date_format(new \DateTime, "Y-m-d");
        } elseif ($startdate == "tomorrow") {
            $startdate = date_format(date_modify(new \DateTime, "+1 day"), "Y-m-d");
        } elseif ($startdate == "thisweekend") {
            $startdate = "all";
            $startdatemin = date_format(date_modify(new \DateTime, "saturday this week"), "Y-m-d");
            $startdatemax = date_format(date_modify(new \DateTime, "sunday this week"), "Y-m-d");
        } elseif ($startdate == "thisweek") {
            $startdate = "all";
            $startdatemin = date_format(date_modify(new \DateTime, "monday this week"), "Y-m-d");
            $startdatemax = date_format(date_modify(new \DateTime, "sunday this week"), "Y-m-d");
        } elseif ($startdate == "nextweek") {
            $startdate = "all";
            $startdatemin = date_format(date_modify(new \DateTime, "monday next week"), "Y-m-d");
            $startdatemax = date_format(date_modify(new \DateTime, "sunday next week"), "Y-m-d");
        } elseif ($startdate == "thismonth") {
            $startdate = "all";
            $startdatemin = date_format(new \DateTime, "Y-m-01");
            $startdatemax = date_format(new \DateTime, "Y-m-t");
        } elseif ($startdate == "nextmonth") {
            $startdate = "all";
            $startdatemin = date_format(date_modify(new \DateTime, "+1 month"), "Y-m-01");
            $startdatemax = date_format(date_modify(new \DateTime, "+1 month"), "Y-m-t");
        }
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $otherthan = array_key_exists('otherthan', $criterias) ? $criterias['otherthan'] : "all";
        $localonly = array_key_exists('localonly', $criterias) ? $criterias['localonly'] : false;
        $location = array_key_exists('location', $criterias) ? $criterias['location'] : "all";
        if ($localonly == "1") {
            $country = $this->locateUser()['country']->getSlug();
        }
        $published = array_key_exists('published', $criterias) ? $criterias['published'] : true;
        $elapsed = array_key_exists('elapsed', $criterias) ? $criterias['elapsed'] : false;
        $organizerEnabled = array_key_exists('organizerEnabled', $criterias) ? $criterias['organizerEnabled'] : true;
        $addedtofavoritesby = array_key_exists('addedtofavoritesby', $criterias) ? $criterias['addedtofavoritesby'] : "all";
        $onsalebypos = array_key_exists('onsalebypos', $criterias) ? $criterias['onsalebypos'] : "all";
        $canbescannedby = array_key_exists('canbescannedby', $criterias) ? $criterias['canbescannedby'] : "all";
        $isOnHomepageSlider = array_key_exists('isOnHomepageSlider', $criterias) ? $criterias['isOnHomepageSlider'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "eventdates.startdate";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "ASC";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $count = array_key_exists('count', $criterias) ? $criterias['count'] : false;

        return $this->em->getRepository("App\Entity\Event")->getEvents($category, $venue, $country, $location, $organizer, $keyword, $slug, $freeonly, $onlineonly, $pricemin, $pricemax, $audience, $startdate, $startdatemin, $startdatemax, $published, $elapsed, $organizerEnabled, $addedtofavoritesby, $onsalebypos, $canbescannedby, $isOnHomepageSlider, $otherthan, $sort, $order, $limit, $count);
    }

    // Returns the users after applying the specified search criterias
    public function getUsers($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $role = array_key_exists('role', $criterias) ? $criterias['role'] : "all";
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $createdbyorganizerslug = array_key_exists('createdbyorganizerslug', $criterias) ? $criterias['createdbyorganizerslug'] : "all";
        $organizername = array_key_exists('organizername', $criterias) ? $criterias['organizername'] : "all";
        $organizerslug = array_key_exists('organizerslug', $criterias) ? $criterias['organizerslug'] : "all";
        $username = array_key_exists('username', $criterias) ? $criterias['username'] : "all";
        $email = array_key_exists('email', $criterias) ? $criterias['email'] : "all";
        $firstname = array_key_exists('firstname', $criterias) ? $criterias['firstname'] : "all";
        $lastname = array_key_exists('lastname', $criterias) ? $criterias['lastname'] : "all";
        $enabled = array_key_exists('enabled', $criterias) ? $criterias['enabled'] : true;
        $countryslug = array_key_exists('countryslug', $criterias) ? $criterias['countryslug'] : "all";
        $followedby = array_key_exists('followedby', $criterias) ? $criterias['followedby'] : "all";
        $hasboughtticketforEvent = array_key_exists('hasboughtticketfor', $criterias) ? $criterias['hasboughtticketfor'] : "all";
        $hasboughtticketforOrganizer = array_key_exists('hasboughtticketfororganizer', $criterias) ? $criterias['hasboughtticketfororganizer'] : "all";
        $apiKey = array_key_exists('apikey', $criterias) ? $criterias['apikey'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $isOnHomepageSlider = array_key_exists('isOnHomepageSlider', $criterias) ? $criterias['isOnHomepageSlider'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "u.createdAt";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "DESC";
        $count = array_key_exists('count', $criterias) ? $criterias['count'] : false;

        return $this->em->getRepository("App\Entity\User")->getUsers($role, $keyword, $createdbyorganizerslug, $organizername, $organizerslug, $username, $email, $firstname, $lastname, $enabled, $countryslug, $slug, $followedby, $hasboughtticketforEvent, $hasboughtticketforOrganizer, $apiKey, $isOnHomepageSlider, $limit, $sort, $order, $count);
    }

    // Returns the reviews after applying the specified search criterias
    public function getReviews($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $user = array_key_exists('user', $criterias) ? $criterias['user'] : "all";
        $event = array_key_exists('event', $criterias) ? $criterias['event'] : "all";
        $organizer = array_key_exists('organizer', $criterias) ? $criterias['organizer'] : "all";
        $visible = array_key_exists('visible', $criterias) ? $criterias['visible'] : true;
        $rating = array_key_exists('rating', $criterias) ? $criterias['rating'] : "all";
        $minrating = array_key_exists('minrating', $criterias) ? $criterias['minrating'] : "all";
        $maxrating = array_key_exists('maxrating', $criterias) ? $criterias['maxrating'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $count = array_key_exists('count', $criterias) ? $criterias['count'] : false;
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "createdAt";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "DESC";

        return $this->em->getRepository("App\Entity\Review")->getReviews($keyword, $slug, $user, $event, $organizer, $visible, $rating, $minrating, $maxrating, $limit, $count, $sort, $order);
    }

    // Returns the blog posts categories after applying the specified search criterias
    public function getBlogPostCategories($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "translations.name";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "ASC";

        return $this->em->getRepository("App\Entity\BlogPostCategory")->getBlogPostCategories($hidden, $keyword, $slug, $limit, $order, $sort);
    }

    // Returns the blog posts after applying the specified search criterias
    public function getBlogPosts($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $selecttags = array_key_exists('selecttags', $criterias) ? $criterias['selecttags'] : false;
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $category = array_key_exists('category', $criterias) ? $criterias['category'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $otherthan = array_key_exists('otherthan', $criterias) ? $criterias['otherthan'] : "all";
        $sort = array_key_exists('order', $criterias) ? $criterias['order'] : "createdAt";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "DESC";

        return $this->em->getRepository("App\Entity\BlogPost")->getBlogPosts($selecttags, $hidden, $keyword, $slug, $category, $limit, $sort, $order, $otherthan);
    }

    // Returns the pages after applying the specified search criterias
    public function getPages($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";

        return $this->em->getRepository("App\Entity\Page")->getPages($slug);
    }

    // Returns the help center categories after applying the specified search criterias
    public function getHelpCenterCategories($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $parent = array_key_exists('parent', $criterias) ? $criterias['parent'] : "all";
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "translations.name";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "ASC";

        return $this->em->getRepository("App\Entity\HelpCenterCategory")->getHelpCenterCategories($parent, $hidden, $keyword, $slug, $limit, $order, $sort);
    }

    // Returns the help center articles after applying the specified search criterias
    public function getHelpCenterArticles($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $selecttags = array_key_exists('selecttags', $criterias) ? $criterias['selecttags'] : false;
        $hidden = array_key_exists('hidden', $criterias) ? $criterias['hidden'] : false;
        $featured = array_key_exists('featured', $criterias) ? $criterias['featured'] : "all";
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $category = array_key_exists('category', $criterias) ? $criterias['category'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $otherthan = array_key_exists('otherthan', $criterias) ? $criterias['otherthan'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "createdAt";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "DESC";

        return $this->em->getRepository("App\Entity\HelpCenterArticle")->getHelpCenterArticles($selecttags, $hidden, $featured, $keyword, $slug, $category, $limit, $sort, $order, $otherthan);
    }

    // Returns the payment gateways after applying the specified search criterias
    public function getPaymentGateways($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $organizer = array_key_exists('organizer', $criterias) ? $criterias['organizer'] : null;
        $enabled = array_key_exists('enabled', $criterias) ? $criterias['enabled'] : true;
        $gatewayFactoryName = array_key_exists('gatewayFactoryName', $criterias) ? $criterias['gatewayFactoryName'] : "all";
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "number";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "ASC";
        $organizerPayoutPaypalEnabled = $this->getSetting("organizer_payout_paypal_enabled");
        $organizerPayoutStripeEnabled = $this->getSetting("organizer_payout_stripe_enabled");

        return $this->em->getRepository("App\Entity\PaymentGateway")->getPaymentGateways($organizer, $enabled, $gatewayFactoryName, $slug, $sort, $order, $organizerPayoutPaypalEnabled, $organizerPayoutStripeEnabled);
    }

    // Returns the orders after applying the specified search criterias
    public function getOrders($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $status = array_key_exists('status', $criterias) ? $criterias['status'] : 1;
        $reference = array_key_exists('reference', $criterias) ? $criterias['reference'] : "all";
        $user = array_key_exists('user', $criterias) ? $criterias['user'] : "all";
        $organizer = array_key_exists('organizer', $criterias) ? $criterias['organizer'] : "all";
        $event = array_key_exists('event', $criterias) ? $criterias['event'] : "all";
        $eventDate = array_key_exists('eventdate', $criterias) ? $criterias['eventdate'] : "all";
        $eventTicket = array_key_exists('eventticket', $criterias) ? $criterias['eventticket'] : "all";
        $upcomingtickets = array_key_exists('upcomingtickets', $criterias) ? $criterias['upcomingtickets'] : "all";
        $datefrom = array_key_exists('datefrom', $criterias) ? $criterias['datefrom'] : "all";
        $dateto = array_key_exists('dateto', $criterias) ? $criterias['dateto'] : "all";
        $paymentgateway = array_key_exists('paymentgateway', $criterias) ? $criterias['paymentgateway'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "createdAt";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "DESC";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $count = array_key_exists('count', $criterias) ? $criterias['count'] : false;
        $ordersQuantityByDateStat = array_key_exists('ordersQuantityByDateStat', $criterias) ? $criterias['ordersQuantityByDateStat'] : false;
        $sumOrderElements = array_key_exists('sumOrderElements', $criterias) ? $criterias['sumOrderElements'] : false;

        if ($this->authChecker->isGranted("ROLE_ATTENDEE") || $this->authChecker->isGranted("ROLE_POINTOFSALE")) {
            $user = $this->security->getUser()->getSlug();
        }
        if ($this->authChecker->isGranted("ROLE_ORGANIZER")) {
            $organizer = $this->security->getUser()->getOrganizer()->getSlug();
        }

        return $this->em->getRepository("App\Entity\Order")->getOrders($status, $user, $organizer, $event, $eventDate, $eventTicket, $reference, $upcomingtickets, $datefrom, $dateto, $paymentgateway, $sort, $order, $limit, $count, $ordersQuantityByDateStat, $sumOrderElements);
    }

    // Returns the payments after applying the specified search criterias
    public function getPayments($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $number = array_key_exists('number', $criterias) ? $criterias['number'] : "all";

        return $this->em->getRepository("App\Entity\Payment")->getPayments($number);
    }

    // Returns the event dates after applying the specified search criterias
    public function getEventDates($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $reference = array_key_exists('reference', $criterias) ? $criterias['reference'] : "all";
        $organizer = array_key_exists('organizer', $criterias) ? $criterias['organizer'] : "all";
        $event = array_key_exists('event', $criterias) ? $criterias['event'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $count = array_key_exists('count', $criterias) ? $criterias['count'] : false;

        return $this->em->getRepository("App\Entity\EventDate")->getEventDates($reference, $organizer, $event, $limit, $count);
    }

    // Returns the event tickets after applying the specified search criterias
    public function getEventTickets($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $reference = array_key_exists('reference', $criterias) ? $criterias['reference'] : "all";
        $organizer = array_key_exists('organizer', $criterias) ? $criterias['organizer'] : "all";
        $event = array_key_exists('event', $criterias) ? $criterias['event'] : "all";
        $eventdate = array_key_exists('eventdate', $criterias) ? $criterias['eventdate'] : "all";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";

        return $this->em->getRepository("App\Entity\EventTicket")->getEventtickets($reference, $organizer, $event, $eventdate, $limit);
    }

    // Returns the bought tickets after applying the specified search criterias
    public function getOrderTickets($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $reference = array_key_exists('reference', $criterias) ? $criterias['reference'] : "all";
        $keyword = array_key_exists('keyword', $criterias) ? $criterias['keyword'] : "all";
        $eventDate = array_key_exists('eventdate', $criterias) ? $criterias['eventdate'] : "all";
        $checkedin = array_key_exists('checkedin', $criterias) ? $criterias['checkedin'] : "all";
        return $this->em->getRepository("App\Entity\OrderTicket")->getOrderTickets($reference, $keyword, $eventDate, $checkedin);
    }

    // Returns the payout requests after applying the specified search criterias
    public function getPayoutRequests($criterias) {
        $this->disableSofDeleteFilterForAdmin($this->em, $this->authChecker);
        $reference = array_key_exists('reference', $criterias) ? $criterias['reference'] : "all";
        $eventdate = array_key_exists('eventdate', $criterias) ? $criterias['eventdate'] : "all";
        $organizer = array_key_exists('organizer', $criterias) ? $criterias['organizer'] : "all";
        if ($this->authChecker->isGranted("ROLE_ORGANIZER")) {
            $organizer = $this->security->getUser()->getOrganizer()->getSlug();
        }
        $datefrom = array_key_exists('datefrom', $criterias) ? $criterias['datefrom'] : "all";
        $dateto = array_key_exists('dateto', $criterias) ? $criterias['dateto'] : "all";
        $status = array_key_exists('status', $criterias) ? $criterias['status'] : "all";
        $sort = array_key_exists('sort', $criterias) ? $criterias['sort'] : "createdAt";
        $order = array_key_exists('order', $criterias) ? $criterias['order'] : "DESC";
        $limit = array_key_exists('limit', $criterias) ? $criterias['limit'] : "all";
        $count = array_key_exists('count', $criterias) ? $criterias['count'] : false;
        return $this->em->getRepository("App\Entity\PayoutRequest")->getPayoutRequests($reference, $eventdate, $organizer, $datefrom, $dateto, $status, $sort, $order, $limit, $count);
    }

    // Sends the payout processed email to the organizer
    public function sendPayoutProcessedEmail($payoutRequest, $emailTo) {
        $email = (new \Swift_Message($this->translator->trans('Your payout request has been processed')))
                ->setFrom($this->getSetting('no_reply_email'))
                ->setTo($emailTo)
                ->setBody(
                $this->templating->render('Dashboard/Shared/Payout/payout-processed-email.html.twig', ['payoutRequest' => $payoutRequest]), 'text/html');

        $this->mailer->send($email);
        return 1;
    }

    // Returns the layout settings entity to be used in the twig templates
    public function getAppLayoutSettings() {
        $appLayoutSettings = $this->em->getRepository("App\Entity\AppLayoutSettings")->find(1);
        return $appLayoutSettings;
    }

    // Returns the menus (header and footer)
    public function getMenus($criterias) {
        $slug = array_key_exists('slug', $criterias) ? $criterias['slug'] : "all";
        $menus = $this->em->getRepository("App\Entity\Menu")->getMenus($slug);
        return $menus;
    }

    // Generates a list of pages to be chosen in a menu element
    public function getLinks() {

        $linksArray = array();

        // Add static pages urls
        $staticPages = $this->getPages(array())->getQuery()->getResult();
        $staticPagesArray = array();
        $staticPagesArray[$this->translator->trans('Homepage')] = $this->router->generate('homepage', ['_locale' => 'en']);
        foreach ($staticPages as $staticPage) {
            $staticPagesArray[$staticPage->getTitle()] = $this->router->generate('page', ['slug' => $staticPage->getSlug(), '_locale' => 'en']);
        }
        $staticPagesArray[$this->translator->trans('Contact')] = $this->router->generate('contact', ['_locale' => 'en']);
        $linksArray[$this->translator->trans("Static Pages")] = $staticPagesArray;

        // Add authentification pages urls
        $authentificationPagesArray = array();
        $authentificationPagesArray[$this->translator->trans('Login')] = $this->router->generate('fos_user_security_login', ['_locale' => 'en']);
        $authentificationPagesArray[$this->translator->trans('Password Resetting')] = $this->router->generate('fos_user_resetting_request', ['_locale' => 'en']);
        $authentificationPagesArray[$this->translator->trans('Attendee Registration')] = $this->router->generate('fos_user_registration_register_attendee', ['_locale' => 'en']);
        $authentificationPagesArray[$this->translator->trans('Organizer Registration')] = $this->router->generate('fos_user_registration_register_organizer', ['_locale' => 'en']);
        $linksArray[$this->translator->trans("Authentification Pages")] = $authentificationPagesArray;

        // Add dashboard pages urls
        $dashboardPagesArray = array();
        $dashboardPagesArray[$this->translator->trans('Attendee tickets')] = $this->router->generate('dashboard_attendee_orders', ['_locale' => 'en']);
        $dashboardPagesArray[$this->translator->trans('Create event')] = $this->router->generate('dashboard_organizer_event_add', ['_locale' => 'en']);
        $linksArray[$this->translator->trans("Dashboard Pages")] = $dashboardPagesArray;

        // Add Category pages urls
        $categoryPagesArray = array();
        $categoryPagesArray[$this->translator->trans('Categories page')] = $this->router->generate('categories', ['_locale' => 'en']);
        $categoryPagesArray[$this->translator->trans('No link, display featured categories dropdown on hover (header menu only)')] = 'categories_dropdown';
        $categoryPagesArray[$this->translator->trans('Display top 4 featured categories (footer section menu only)')] = 'footer_categories_section';
        $categories = $this->getCategories(array())->getQuery()->getResult();
        foreach ($categories as $category) {
            $categoryPagesArray[$this->translator->trans('Category') . ' - ' . $category->getName()] = $this->router->generate('events', ['category' => $category->getSlug(), '_locale' => 'en']);
        }
        $linksArray[$this->translator->trans("Event Categories")] = $categoryPagesArray;

        // Add Blog post pages urls
        $blogPagesArray = array();
        $blogPagesArray[$this->translator->trans('Blog page')] = $this->router->generate('blog', ['_locale' => 'en']);
        $blogPosts = $this->getBlogPosts(array())->getQuery()->getResult();
        foreach ($blogPosts as $blogPost) {
            $blogPagesArray[$this->translator->trans('Blog post') . ' - ' . $blogPost->getName()] = $this->router->generate('blog_article', ['slug' => $blogPost->getSlug(), '_locale' => 'en']);
        }
        $linksArray[$this->translator->trans("Blog Pages")] = $blogPagesArray;

        // Add event pages urls
        $eventPagesArray = array();
        $eventPagesArray[$this->translator->trans('Events page')] = $this->router->generate('events', ['_locale' => 'en']);
        $events = $this->getEvents(array())->getQuery()->getResult();
        foreach ($events as $event) {
            $eventPagesArray[$this->translator->trans('Event') . ' - ' . $event->getName()] = $this->router->generate('event', ['slug' => $event->getSlug(), '_locale' => 'en']);
        }
        $linksArray[$this->translator->trans("Events Pages")] = $eventPagesArray;

        // Add help center pages urls
        $helpCenterPagesArray = array();
        $helpCenterPagesArray[$this->translator->trans('Help Center page')] = $this->router->generate('help_center', ['_locale' => 'en']);
        $helpCenterCategories = $this->getHelpCenterCategories(array())->getQuery()->getResult();
        $helpCenterArticles = $this->getHelpCenterArticles(array())->getQuery()->getResult();
        foreach ($helpCenterCategories as $helpCenterCategory) {
            $helpCenterPagesArray[$this->translator->trans('Help Center Category') . ' - ' . $helpCenterCategory->getName()] = $this->router->generate('help_center_category', ['slug' => $helpCenterCategory->getSlug(), '_locale' => 'en']);
        }
        foreach ($helpCenterArticles as $helpCenterArticle) {
            $helpCenterPagesArray[$this->translator->trans('Help Center Article') . ' - ' . $helpCenterArticle->getTitle()] = $this->router->generate('help_center_article', ['slug' => $helpCenterArticle->getSlug(), '_locale' => 'en']);
        }
        $linksArray[$this->translator->trans("Help Center Pages")] = $helpCenterPagesArray;

        // Add organizers pages urls
        $organizersPagesArray = array();
        $organizers = $this->getUsers(array("role" => "organizer"))->getQuery()->getResult();
        foreach ($organizers as $organizer) {
            $organizersPagesArray[$this->translator->trans('Organizer Profile') . ' - ' . $organizer->getOrganizer()->getName()] = $this->router->generate('organizer', ['slug' => $organizer->getOrganizer()->getSlug(), '_locale' => 'en']);
        }
        $linksArray[$this->translator->trans("Organizers Pages")] = $organizersPagesArray;

        // Add venues pages urls
        $venuesPagesArray = array();
        $venuesPagesArray[$this->translator->trans('Venues page')] = $this->router->generate('venues', ['_locale' => 'en']);
        $venues = $this->getVenues(array())->getQuery()->getResult();
        foreach ($venues as $venue) {
            $venuesPagesArray[$this->translator->trans('Venue') . ' - ' . $venue->getName()] = $this->router->generate('venue', ['slug' => $venue->getSlug(), '_locale' => 'en']);
        }
        $linksArray[$this->translator->trans("Venues Pages")] = $venuesPagesArray;

        return $linksArray;
    }

    // Get route name from path
    public function getRouteName($path = null) {
        try {
            if ($path) {
                return $this->urlMatcherInterface->match($path)['_route'];
            } else {
                return $this->urlMatcherInterface->match($this->requestStack->getCurrentRequest()->getPathInfo())['_route'];
            }
        } catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
            return null;
        }
    }

    // Checks if string ends with string
    function endsWith($haystack, $needle) {
        $length = strlen($needle);
        if (!$length) {
            return true;
        }
        return substr($haystack, -$length) === $needle;
    }

    // Changes the link locale
    public function changeLinkLocale($newLocale, $link) {
        if ($link == "categories_dropdown" || $link == "footer_categories_section") {
            return $link;
        }
        if (strpos($link, "/en/") !== false) {
            return str_replace("/en/", "/" . $newLocale . "/", $link);
        } elseif (strpos($link, "/fr/") !== false) {
            return str_replace("/fr/", "/" . $newLocale . "/", $link);
        } elseif (strpos($link, "/ar/") !== false) {
            return str_replace("/ar/", "/" . $newLocale . "/", $link);
        } elseif ($this->endsWith($link, "/en")) {
            return str_replace("/en", "/" . $newLocale, $link);
        } elseif ($this->endsWith($link, "/fr")) {
            return str_replace("/fr", "/" . $newLocale, $link);
        } elseif ($this->endsWith($link, "/ar")) {
            return str_replace("/ar", "/" . $newLocale, $link);
        }
        return 'x';
    }

    // Returns the currencies
    public function getCurrencies($criterias) {
        $ccy = array_key_exists('ccy', $criterias) ? $criterias['ccy'] : "all";
        $symbol = array_key_exists('symbol', $criterias) ? $criterias['symbol'] : "all";
        return $this->em->getRepository("App\Entity\Currency")->getCurrencies($ccy, $symbol);
    }

}
