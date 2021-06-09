<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderElementRepository")
 * @ORM\Table(name="eventic_order_element")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class OrderElement {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderelements")
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="EventTicket", inversedBy="orderelements")
     */
    private $eventticket;

    /**
     * @ORM\OneToMany(targetEntity="OrderTicket", mappedBy="orderelement", cascade={"persist", "remove"})
     */
    private $tickets;

    /**
     * @ORM\OneToMany(targetEntity="TicketReservation", mappedBy="orderelement", cascade={"persist", "remove"}, fetch = "EAGER")
     */
    private $ticketsReservations;

    /**
     * @var decimal
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $unitprice;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct() {
        $this->tickets = new ArrayCollection();
        $this->ticketsReservations = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getScannedTicketsCount() {
        $count = 0;
        foreach ($this->tickets as $ticket) {
            if ($ticket->getScanned()) {
                $count++;
            }
        }
        return $count;
    }

    public function belongsToOrganizer($slug) {
        if ($this->eventticket->getEventdate()->getEvent()->getOrganizer()->getSlug() == $slug) {
            return true;
        } else {
            return false;
        }
    }

    public function displayUnitPrice() {
        return (float) $this->unitprice;
    }

    public function getPrice($formattedForPayoutApproval = false) {
        if ($formattedForPayoutApproval) {
            return $this->unitprice * $this->quantity;
        }
        return (float) $this->unitprice * $this->quantity;
    }

    public function getOrder() {
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;

        return $this;
    }

    public function getEventticket() {
        return $this->eventticket;
    }

    public function setEventticket($eventticket) {
        $this->eventticket = $eventticket;

        return $this;
    }

    public function getUnitprice() {
        return $this->unitprice;
    }

    public function setUnitprice($unitprice) {
        $this->unitprice = $unitprice;

        return $this;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection|OrderTicket[]
     */
    public function getTickets() {
        return $this->tickets;
    }

    public function addTicket($ticket) {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setOrderelement($this);
        }

        return $this;
    }

    public function removeTicket($ticket) {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
// set the owning side to null (unless already changed)
            if ($ticket->getOrderelement() === $this) {
                $ticket->setOrderelement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TicketReservation[]
     */
    public function getTicketsReservations() {
        return $this->ticketsReservations;
    }

    public function addTicketsReservation($ticketsReservation) {
        if (!$this->ticketsReservations->contains($ticketsReservation)) {
            $this->ticketsReservations[] = $ticketsReservation;
            $ticketsReservation->setOrderelement($this);
        }

        return $this;
    }

    public function removeTicketsReservation($ticketsReservation) {
        if ($this->ticketsReservations->contains($ticketsReservation)) {
            $this->ticketsReservations->removeElement($ticketsReservation);
// set the owning side to null (unless already changed)
            if ($ticketsReservation->getOrderelement() === $this) {
                $ticketsReservation->setOrderelement(null);
            }
        }

        return $this;
    }

    public function getDeletedAt() {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

}
