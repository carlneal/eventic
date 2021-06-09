<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderTicketRepository")
 * @ORM\Table(name="eventic_order_ticket")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class OrderTicket {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="OrderElement", inversedBy="tickets")
     */
    private $orderelement;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $reference;

    /**
     * @ORM\Column(type="boolean")
     */
    private $scanned;

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

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getId() {
        return $this->id;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;

        return $this;
    }

    public function getScanned() {
        return $this->scanned;
    }

    public function setScanned($scanned) {
        $this->scanned = $scanned;

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

    public function getDeletedAt() {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getOrderelement() {
        return $this->orderelement;
    }

    public function setOrderelement($orderelement) {
        $this->orderelement = $orderelement;

        return $this;
    }

}
