<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartElementRepository")
 * @ORM\Table(name="eventic_cart_element")
 */
class CartElement {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="cartelements")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="EventTicket", inversedBy="cartelements")
     */
    private $eventticket;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var decimal
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $ticketFee;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getPrice() {
        return (float) $this->eventticket->getSalePrice() * $this->quantity;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    public function getEventticket() {
        return $this->eventticket;
    }

    public function setEventticket($eventticket) {
        $this->eventticket = $eventticket;

        return $this;
    }

    public function getTicketFee() {
        return (float) $this->ticketFee;
    }

    public function setTicketFee($ticketFee) {
        $this->ticketFee = $ticketFee;

        return $this;
    }

}
