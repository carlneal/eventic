<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventDateRepository")
 * @ORM\Table(name="eventic_event_date")
 */
class EventDate {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventdates")
     */
    private $event;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull(groups={"create", "update"})
     */
    private $online;

    /**
     * @ORM\ManyToOne(targetEntity="Venue", inversedBy="eventdates")
     * @ORM\JoinColumn(nullable=true)
     */
    private $venue;

    /**
     * @ORM\OneToMany(targetEntity="EventTicket", mappedBy="eventdate", cascade={"persist", "remove"}, fetch = "EAGER", orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @Assert\Valid(groups={"create", "update"})
     */
    private $tickets;

    /**
     * @ORM\ManyToMany(targetEntity="Scanner", inversedBy="eventdates", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="eventic_eventdate_scanner",
     *   joinColumns={@ORM\JoinColumn(name="eventdate_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="scanner_id", referencedColumnName="id")}
     * )
     */
    private $scanners;

    /**
     * @ORM\ManyToMany(targetEntity="PointOfSale", inversedBy="eventdates", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="eventic_eventdate_pointofsale",
     *   joinColumns={@ORM\JoinColumn(name="eventdate_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="pointofsale_id", referencedColumnName="id")}
     * )
     */
    private $pointofsales;

    /**
     * @ORM\OneToMany(targetEntity="PayoutRequest", mappedBy="eventDate", cascade={"persist", "remove"}, fetch = "LAZY")
     */
    private $payoutRequests;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull(groups={"create", "update"})
     */
    private $active;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $reference;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\NotBlank(groups={"create", "update"})
     */
    private $startdate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\GreaterThan(propertyPath="startdate", groups={"create", "update"})
     */
    private $enddate;

    public function __construct() {
        $this->tickets = new ArrayCollection();
        $this->scanners = new ArrayCollection();
        $this->pointofsales = new ArrayCollection();
        $this->reference = $this->generateReference(10);
        $this->payoutRequests = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function payoutRequested() {
        foreach ($this->payoutRequests as $payoutRequest) {
            if ($payoutRequest->getStatus() == 0 || $payoutRequest->getStatus() == 1) {
                return true;
            }
        }
        return false;
    }

    public function payoutRequestStatusClass() {
        foreach ($this->payoutRequests as $payoutRequest) {
            if ($payoutRequest->getStatus() == 0 || $payoutRequest->getStatus() == 1) {
                return $payoutRequest->getStatusClass();
            }
        }
        return "Unknown";
    }

    public function payoutRequestStatus() {
        foreach ($this->payoutRequests as $payoutRequest) {
            if ($payoutRequest->getStatus() == 0 || $payoutRequest->getStatus() == 1) {
                return $payoutRequest->stringifyStatus();
            }
        }
        return "Unknown";
    }

    public function canBeScannedBy($scanner) {
        return $this->getScanners()->contains($scanner);
    }

    public function isOnSaleByPos($pointOfSale) {
        return $this->getPointofsales()->contains($pointOfSale);
    }

    public function getTotalCheckInPercentage() {
        if ($this->getOrderElementsQuantitySum() == 0)
            return 0;
        return round(($this->getScannedTicketsCount() / $this->getOrderElementsQuantitySum()) * 100);
    }

    public function getScannedTicketsCount() {
        $count = 0;
        foreach ($this->tickets as $ticket) {
            $count += $ticket->getScannedTicketsCount();
        }
        return $count;
    }

    public function getTotalSalesPercentage() {
        if ($this->getTicketsQuantitySum() == 0)
            return 0;
        else
            return round(($this->getOrderElementsQuantitySum() / $this->getTicketsQuantitySum()) * 100);
    }

    public function getTicketsQuantitySum() {
        $sum = 0;
        foreach ($this->tickets as $eventDateTicket) {
            $sum += $eventDateTicket->getQuantity();
        }
        return $sum;
    }

    public function getSales($role = "all", $user = "all", $formattedForPayoutApproval = false, $includeFees = false) {
        $sum = 0;
        foreach ($this->tickets as $eventDateTicket) {
            $sum += $eventDateTicket->getSales($role, $user, $formattedForPayoutApproval, $includeFees);
        }
        return $sum;
    }

    public function getTotalTicketFees() {
        return $this->getSales("all", "all", false, true) - $this->getSales();
    }

    public function getTicketPricePercentageCutSum($role = "all") {
        $sum = 0;
        foreach ($this->tickets as $eventDateTicket) {
            $sum += $eventDateTicket->getTicketPricePercentageCutSum($role);
        }
        return $sum;
    }

    public function getOrganizerPayoutAmount() {
        return $this->getSales() - $this->getTicketPricePercentageCutSum() - $this->getSales("ROLE_POINTOFSALE");
    }

    public function displayPosNames() {
        $pointofsales = '';
        if (count($this->pointofsales) > 0) {
            foreach ($this->pointofsales as $pointofsale) {
                $pointofsales .= $pointofsale->getName() . ', ';
            }
        }
        return rtrim($pointofsales, ', ');
    }

    public function displayScannersNames() {
        $scanners = '';
        if (count($this->scanners) > 0) {
            foreach ($this->scanners as $scanner) {
                $scanners .= $scanner->getName() . ', ';
            }
        }
        return rtrim($scanners, ', ');
    }

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

    public function getOrderElementsQuantitySum($status = 1, $user = "all", $role = "all") {
        $sum = 0;
        foreach ($this->tickets as $ticket) {
            $sum += $ticket->getOrderElementsQuantitySum($status, $user, $role);
        }
        return $sum;
    }

    public function isSoldOut() {
        foreach ($this->tickets as $ticket) {
            if (!$ticket->isSoldOut()) {
                return false;
            }
        }
        return true;
    }

    public function hasATicketOnSale() {
        foreach ($this->tickets as $ticket) {
            if ($ticket->isOnSale()) {
                return true;
            }
        }
        return false;
    }

    public function isOnSale() {
        return (
                $this->event->getOrganizer()->getUser()->isEnabled() && $this->active && $this->event->getPublished() && ($this->getStartdate() > new \Datetime) && (!$this->isSoldOut()) && $this->hasATicketOnSale() && (!$this->payoutRequested())
                );
    }

    public function stringifyStatus() {
        if (!$this->event->getOrganizer()->getUser()->isEnabled()) {
            return "Organizer is disabled";
        } else if (!$this->event->getPublished()) {
            return "Event is not published";
        } else if (!$this->active) {
            return "Event date is disabled";
        } else if ($this->getStartdate() < new \Datetime) {
            return "Event already started";
        } else if ($this->isSoldOut()) {
            return "Sold out";
        } else if ($this->payoutRequested()) {
            return "Locked (Payout request " . strtolower($this->payoutRequestStatus()) . ")";
        } else if (!$this->hasATicketOnSale()) {
            return "No ticket on sale";
        } else {
            return "On sale";
        }
    }

    public function stringifyStatusClass() {
        if (!$this->event->getOrganizer()->getUser()->isEnabled()) {
            return "danger";
        } else if (!$this->active) {
            return "danger";
        } else if (!$this->event->getPublished()) {
            return "warning";
        } else if ($this->getStartdate() < new \Datetime) {
            return "info";
        } else if ($this->isSoldOut()) {
            return "warning";
        } else if ($this->payoutRequested()) {
            return "warning";
        } else if (!$this->hasATicketOnSale()) {
            return "danger";
        } else {
            return "success";
        }
    }

    public function isFree() {
        foreach ($this->tickets as $ticket) {
            if (!$ticket->getFree()) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function getCheapestTicket() {
        $cheapestticket = $this->tickets[0];
        foreach ($this->tickets as $ticket) {
            if ($ticket->getSalePrice() > 0) {
                if ($ticket->getSalePrice() < $cheapestticket->getSalePrice()) {
                    $cheapestticket = $ticket;
                }
            }
        }
        return $cheapestticket;
    }

    public function getVenue() {
        return $this->venue;
    }

    public function setVenue($venue) {
        $this->venue = $venue;

        return $this;
    }

    /**
     * @return Collection|EventTicket[]
     */
    public function getTickets() {
        return $this->tickets;
    }

    public function addTicket($ticket) {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setEventdate($this);
        }

        return $this;
    }

    public function removeTicket($ticket) {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
// set the owning side to null (unless already changed)
            if ($ticket->getEventdate() === $this) {
                $ticket->setEventdate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Scanner[]
     */
    public function getScanners() {
        return $this->scanners;
    }

    public function addScanner($scanner) {
        if (!$this->scanners->contains($scanner)) {
            $this->scanners[] = $scanner;
        }

        return $this;
    }

    public function removeScanner($scanner) {
        if ($this->scanners->contains($scanner)) {
            $this->scanners->removeElement($scanner);
        }

        return $this;
    }

    /**
     * @return Collection|PointOfSale[]
     */
    public function getPointofsales() {
        return $this->pointofsales;
    }

    public function addPointofsale($pointofsale) {
        if (!$this->pointofsales->contains($pointofsale)) {
            $this->pointofsales[] = $pointofsale;
        }

        return $this;
    }

    public function removePointofsale($pointofsale) {
        if ($this->pointofsales->contains($pointofsale)) {
            $this->pointofsales->removeElement($pointofsale);
        }

        return $this;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;

        return $this;
    }

    public function getStartdate() {
        return $this->startdate;
    }

    public function setStartdate($startdate) {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate() {
        return $this->enddate;
    }

    public function setEnddate($enddate) {
        $this->enddate = $enddate;

        return $this;
    }

    public function getEvent() {
        return $this->event;
    }

    public function setEvent($event) {
        $this->event = $event;

        return $this;
    }

    public function getOnline() {
        return $this->online;
    }

    public function setOnline($online) {
        $this->online = $online;

        return $this;
    }

    /**
     * @return Collection|PayoutRequest[]
     */
    public function getPayoutRequests() {
        return $this->payoutRequests;
    }

    public function addPayoutRequest($payoutRequest) {
        if (!$this->payoutRequests->contains($payoutRequest)) {
            $this->payoutRequests[] = $payoutRequest;
            $payoutRequest->setEventDate($this);
        }

        return $this;
    }

    public function removePayoutRequest($payoutRequest) {
        if ($this->payoutRequests->contains($payoutRequest)) {
            $this->payoutRequests->removeElement($payoutRequest);
// set the owning side to null (unless already changed)
            if ($payoutRequest->getEventDate() === $this) {
                $payoutRequest->setEventDate(null);
            }
        }

        return $this;
    }

}
