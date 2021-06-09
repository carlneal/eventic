<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketReservationRepository")
 * @ORM\Table(name="eventic_ticket_reservation")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class TicketReservation {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="EventTicket", inversedBy="ticketreservations")
     */
    private $eventticket;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ticketreservations")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="OrderElement", inversedBy="ticketsReservations")
     */
    private $orderelement;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $expiresAt
     *
     * @ORM\Column(type="datetime")
     */
    private $expiresAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getId() {
        return $this->id;
    }

    public function isExpired() {
        return $this->expiresAt < new \DateTime;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    public function getEventticket() {
        return $this->eventticket;
    }

    public function setEventticket($eventticket) {
        $this->eventticket = $eventticket;

        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getExpiresAt() {
        return $this->expiresAt;
    }

    public function setExpiresAt($expiresAt) {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getOrderelement() {
        return $this->orderelement;
    }

    public function setOrderelement($orderelement) {
        $this->orderelement = $orderelement;

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
