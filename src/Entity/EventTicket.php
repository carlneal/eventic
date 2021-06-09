<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventTicketRepository")
 * @ORM\Table(name="eventic_event_date_ticket")
 */
class EventTicket {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="EventDate", inversedBy="tickets")
     */
    private $eventdate;

    /**
     * @ORM\OneToMany(targetEntity="CartElement", mappedBy="eventticket", cascade={"remove"})
     */
    private $cartelements;

    /**
     * @ORM\OneToMany(targetEntity="OrderElement", mappedBy="eventticket", cascade={"remove"})
     */
    private $orderelements;

    /**
     * @ORM\OneToMany(targetEntity="TicketReservation", mappedBy="eventticket", cascade={"remove"})
     */
    private $ticketreservations;

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
     * @var string
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Length(min = 2, max = 50, groups={"create", "update"})
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull(groups={"create", "update"})
     */
    private $free;

    /**
     * @var decimal
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var decimal
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Assert\LessThan(propertyPath="price", groups={"create", "update"})
     */
    private $promotionalprice;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(groups={"create", "update"})
     */
    private $quantity;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\LessThan(propertyPath="quantity", groups={"create", "update"})
     */
    private $ticketsperattendee;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $salesstartdate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\GreaterThan(propertyPath="salesstartdate", groups={"create", "update"})
     */
    private $salesenddate;

    /**
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    public function __construct() {
        $this->orderelements = new ArrayCollection();
        $this->reference = $this->generateReference(10);
        $this->cartelements = new ArrayCollection();
        $this->ticketreservations = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
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

    public function getTotalCheckInPercentage() {
        if ($this->getOrderElementsQuantitySum() == 0)
            return 0;
        return round(($this->getScannedTicketsCount() / $this->getOrderElementsQuantitySum()) * 100);
    }

    public function getSalesPercentage() {
        if ($this->quantity == 0)
            return 0;
        else
            return round(($this->getOrderElementsQuantitySum() / $this->quantity) * 100);
    }

    public function getScannedTicketsCount() {
        $count = 0;
        foreach ($this->orderelements as $orderElement) {
            foreach ($orderElement->getTickets() as $ticket) {
                if ($ticket->getScanned())
                    $count++;
            }
        }
        return $count;
    }

    public function getSales($role = "all", $user = "all", $formattedForPayoutApproval = false, $includeFees = false) {
        $sum = 0;
        foreach ($this->orderelements as $orderelement) {
            if ($orderelement->getOrder()->getStatus() === 1 && ($role == "all" || $orderelement->getOrder()->getUser()->hasRole($role)) && ($user == "all" || $orderelement->getOrder()->getUser() == $user)) {
                $sum += $orderelement->getPrice($formattedForPayoutApproval);
            }
        }
        if ($includeFees) {
            $sum += $this->getTotalFees();
        }
        return $sum;
    }

    public function getTicketPricePercentageCutSum($role = "all") {
        $sum = 0;
        foreach ($this->orderelements as $orderelement) {
            if ($role == "all" || $orderelement->getOrder()->getUser()->hasRole($role)) {
                $sum += (($orderelement->getOrder()->getTicketPricePercentageCut() * $orderelement->getUnitprice()) / 100) * $orderelement->getQuantity();
            }
        }
        return $sum;
    }

    public function getTotalTicketFees($role = "all", $user = "all") {
        $sum = 0;
        foreach ($this->orderelements as $orderelement) {
            if ($orderelement->getOrder()->getStatus() === 1 && ($role == "all" || $orderelement->getOrder()->getUser()->hasRole($role)) && ($user == "all" || $orderelement->getOrder()->getUser() == $user) && !$this->free) {
                $sum += $orderelement->getOrder()->getTicketFee() * $orderelement->getQuantity();
            }
        }
        return $sum;
    }

    public function getTotalFees() {
        $sum = 0;
        $sum += $this->getTotalTicketFees();
        return $sum;
    }

    public function isOnSale() {
        if (!$this->eventdate || !$this->eventdate->getEvent() || !$this->eventdate->getEvent()->getOrganizer() || !$this->eventdate->getEvent()->getOrganizer()->getUser()) {
            return false;
        }

        return
                $this->eventdate->getEvent()->getOrganizer()->getUser()->isEnabled() && $this->eventdate->getEvent()->getPublished() && $this->eventdate->getActive() && ($this->eventdate->getStartdate() >= new \Datetime) && $this->active && !$this->isSoldOut() && ($this->salesstartdate < new \Datetime || !$this->salesstartdate) && ($this->salesenddate > new \Datetime || !$this->salesenddate) && (!$this->eventdate->payoutRequested())
        ;
    }

    public function stringifyStatus() {
        if (!$this->eventdate->getEvent()->getOrganizer()->getUser()->isEnabled()) {
            return "Organizer is disabled";
        } else if (!$this->eventdate->getEvent()->getPublished()) {
            return "Event is not published";
        } else if (!$this->eventdate->getActive()) {
            return "Event date is disabled";
        } else if ($this->eventdate->getStartdate() < new \Datetime) {
            return "Event already started";
        } else if (!$this->active) {
            return "Event ticket is disabled";
        } else if ($this->isSoldOut()) {
            return "Sold out";
        } else if ($this->salesstartdate > new \Datetime && $this->salesstartdate) {
            return "Sale didn't start yet";
        } else if ($this->salesenddate < new \Datetime && $this->salesstartdate) {
            return "Sale ended";
        } else if ($this->eventdate->payoutRequested()) {
            return "Locked (Payout request " . strtolower($this->eventdate->payoutRequestStatus()) . ")";
        } else {
            return "On sale";
        }
    }

    public function stringifyStatusClass() {
        if (!$this->eventdate->getEvent()->getOrganizer()->getUser()->isEnabled()) {
            return "danger";
        } else if (!$this->eventdate->getEvent()->getPublished()) {
            return "danger";
        } else if (!$this->eventdate->getActive()) {
            return "danger";
        } else if ($this->eventdate->getStartdate() < new \Datetime) {
            return "info";
        } else if (!$this->active) {
            return "danger";
        } else if ($this->isSoldOut()) {
            return "warning";
        } else if ($this->salesstartdate > new \Datetime && $this->salesstartdate) {
            return "info";
        } else if ($this->salesenddate < new \Datetime && $this->salesstartdate) {
            return "warning";
        } else if ($this->eventdate->payoutRequested()) {
            return "warning";
        } else {
            return "success";
        }
    }

    public function getOrderElementsQuantitySum($status = 1, $user = "all", $role = "all") {
        $sum = 0;
        foreach ($this->orderelements as $orderelement) {
            if (($status == "all" || $orderelement->getOrder()->getStatus() === $status) && ($user == "all" || $orderelement->getOrder()->getUser() == $user) && ($role == "all" || $orderelement->getOrder()->getUser()->hasRole($role))) {
                $sum += $orderelement->getQuantity();
            }
        }
        return $sum;
    }

    public function getValidTicketReservationsQuantitySum($user = null) {
        $sum = 0;
        foreach ($this->ticketreservations as $ticketreservation) {
            if (!$ticketreservation->isExpired() && ($user == null || $ticketreservation->getUser() == $user)) {
                $sum += $ticketreservation->getQuantity();
            }
        }
        return $sum;
    }

    public function getValidTicketReservationExpirationDate($user) {
        foreach ($this->ticketreservations as $ticketreservation) {
            if (!$ticketreservation->isExpired() && $ticketreservation->getUser() == $user) {
                return $ticketreservation->getExpiresAt();
            }
        }
        return null;
    }

    public function getTicketsLeftCount() {
        return $this->quantity - $this->getOrderElementsQuantitySum() - $this->getValidTicketReservationsQuantitySum();
    }

    public function getMaxTicketsForSaleCount($user) {
        if ($this->ticketsperattendee) {
            if ($this->getTicketsLeftCount() >= $this->ticketsperattendee) {
                return $this->ticketsperattendee - $this->getOrderElementsQuantitySum(1, $user);
            } else {
                return $this->getTicketsLeftCount() - $this->ticketsperattendee - $this->getOrderElementsQuantitySum(1, $user);
            }
        } else {
            return $this->quantity - $this->getOrderElementsQuantitySum();
        }
    }

    public function isSoldOut() {
        if ($this->quantity == 0 || $this->getTicketsLeftCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getSalePrice() {
        if ($this->promotionalprice) {
            return (float) $this->getPromotionalprice();
        } elseif ($this->price) {
            return (float) $this->getPrice();
        } else {
            return 0;
        }
    }

    public function getEventdate() {
        return $this->eventdate;
    }

    public function setEventdate($eventdate) {
        $this->eventdate = $eventdate;

        return $this;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;

        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    public function getPrice() {
        return (float) $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;

        return $this;
    }

    public function getPromotionalprice() {
        return (float) $this->promotionalprice;
    }

    public function setPromotionalprice($promotionalprice) {
        $this->promotionalprice = $promotionalprice;

        return $this;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTicketsperattendee() {
        return $this->ticketsperattendee;
    }

    public function setTicketsperattendee($ticketsperattendee) {
        $this->ticketsperattendee = $ticketsperattendee;

        return $this;
    }

    /**
     * @return Collection|OrderElement[]
     */
    public function getOrderelements() {
        return $this->orderelements;
    }

    public function addOrderelement($orderelement) {
        if (!$this->orderelements->contains($orderelement)) {
            $this->orderelements[] = $orderelement;
            $orderelement->setEventticket($this);
        }

        return $this;
    }

    public function removeOrderelement($orderelement) {
        if ($this->orderelements->contains($orderelement)) {
            $this->orderelements->removeElement($orderelement);
// set the owning side to null (unless already changed)
            if ($orderelement->getEventticket() === $this) {
                $orderelement->setEventticket(null);
            }
        }

        return $this;
    }

    public function getSalesstartdate() {
        return $this->salesstartdate;
    }

    public function setSalesstartdate($salesstartdate) {
        $this->salesstartdate = $salesstartdate;

        return $this;
    }

    public function getSalesenddate() {
        return $this->salesenddate;
    }

    public function setSalesenddate($salesenddate) {
        $this->salesenddate = $salesenddate;

        return $this;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Collection|CartElement[]
     */
    public function getCartelements() {
        return $this->cartelements;
    }

    public function addCartelement($cartelement) {
        if (!$this->cartelements->contains($cartelement)) {
            $this->cartelements[] = $cartelement;
            $cartelement->setEventticket($this);
        }

        return $this;
    }

    public function removeCartelement($cartelement) {
        if ($this->cartelements->contains($cartelement)) {
            $this->cartelements->removeElement($cartelement);
// set the owning side to null (unless already changed)
            if ($cartelement->getEventticket() === $this) {
                $cartelement->setEventticket(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TicketReservation[]
     */
    public function getTicketreservations() {
        return $this->ticketreservations;
    }

    public function addTicketreservation($ticketreservation) {
        if (!$this->ticketreservations->contains($ticketreservation)) {
            $this->ticketreservations[] = $ticketreservation;
            $ticketreservation->setEventticket($this);
        }

        return $this;
    }

    public function removeTicketreservation($ticketreservation) {
        if ($this->ticketreservations->contains($ticketreservation)) {
            $this->ticketreservations->removeElement($ticketreservation);
// set the owning side to null (unless already changed)
            if ($ticketreservation->getEventticket() === $this) {
                $ticketreservation->setEventticket(null);
            }
        }

        return $this;
    }

    public function getFree() {
        return $this->free;
    }

    public function setFree($free) {
        $this->free = $free;

        return $this;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;

        return $this;
    }

}
