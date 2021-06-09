<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="eventic_order")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Order {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="OrderElement", cascade={"persist", "remove"}, mappedBy="order", fetch="EAGER")
     */
    private $orderelements;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentGateway", inversedBy="orders")
     * @ORM\JoinColumn(nullable=true)
     */
    private $paymentgateway;

    /**
     * @ORM\OneToOne(targetEntity="Payment", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $payment;

    /**
     * @var string
     * @ORM\Column(type="string", length=15)
     */
    private $reference;

    /**
     * @var string
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $note;

    /**
     * -2: failed / -1: cancel / 0: waiting for payment / 1: paid
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @var decimal
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $ticketFee;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $ticketPricePercentageCut;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $currencyCcy;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $currencySymbol;

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

    public function __construct() {
        $this->status = 0;
        $this->orderelements = new ArrayCollection();
    }

    public function containsEvent($event) {
        foreach ($this->orderelements as $orderElement) {
            if ($orderElement->getEventticket()->getEventdate()->getEvent() == $event) {
                return true;
            }
        }
        return false;
    }

// -2: failed / -1: cancel / 0: waiting for payment / 1: paid

    public function getStatusClass() {

        switch ($this->status) {
            case -2:
                return "danger";
                break;
            case -1:
                return "danger";
                break;
            case 0:
                return "warning";
                break;
            case 1:
                return "success";
                break;
            default:
                return "danger";
        }
    }

    public function stringifyStatus() {

        switch ($this->status) {
            case -2:
                return "Failed";
                break;
            case -1:
                return "Canceled";
                break;
            case 0:
                return "Awaiting payment";
                break;
            case 1:
                return "Paid";
                break;
            default:
                return "Unknown";
        }
    }

    public function getPaymentStatusClass($status) {
        if ($status == "new") {
            return "info";
        } else if ($status == "pending") {
            return "warning";
        } else if ($status == "authorized") {
            return "success";
        } else if ($status == "captured") {
            return "success";
        } else if ($status == "canceled") {
            return "danger";
        } else if ($status == "suspended") {
            return "danger";
        } else if ($status == "failed") {
            return "danger";
        } else if ($status == "unknown") {
            return "danger";
        }
    }

    public function getOrderElementsQuantitySum($status = "all", $organizer = "all") {
        $count = 0;
        if ($status == "all" || $this->status === $status) {
            foreach ($this->orderelements as $orderelement) {
                if ($organizer == "all" || $orderelement->getEventticket()->getEventdate()->getEvent()->getOrganizer()->getSlug() == $organizer) {
                    $count += $orderelement->getQuantity();
                }
            }
        }
        return $count;
    }

    public function getOrderElementsPriceSum($includeFees = false) {
        $sum = 0;
        foreach ($this->orderelements as $orderelement) {
            $sum += $orderelement->getPrice();
        }
        if ($includeFees) {
            $sum += $this->getTotalFees();
        }
        return (float) $sum;
    }

    public function getTotalTicketFees() {
        if (!$this->getTicketFee()) {
            return 0;
        }
        return $this->getNotFreeOrderElementsQuantitySum() * $this->getTicketFee();
    }

    public function getTotalFees() {
        $sum = 0;
        $sum += $this->getTotalTicketFees();
        return $sum;
    }

    public function getNotFreeOrderElementsQuantitySum() {
        $sum = 0;
        foreach ($this->orderelements as $orderelement) {
            if (!$orderelement->getEventticket()->getFree()) {
                $sum += $orderelement->getQuantity();
            }
        }
        return $sum;
    }

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

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;

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
            $orderelement->setOrder($this);
        }

        return $this;
    }

    public function removeOrderelement($orderelement) {
        if ($this->orderelements->contains($orderelement)) {
            $this->orderelements->removeElement($orderelement);
// set the owning side to null (unless already changed)
            if ($orderelement->getOrder() === $this) {
                $orderelement->setOrder(null);
            }
        }

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

    public function getPaymentgateway() {
        return $this->paymentgateway;
    }

    public function setPaymentgateway($paymentgateway) {
        $this->paymentgateway = $paymentgateway;

        return $this;
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;

        return $this;
    }

    public function getPayment() {
        return $this->payment;
    }

    public function setPayment($payment) {
        $this->payment = $payment;

        return $this;
    }

    public function getTicketFee() {
        return (float) $this->ticketFee;
    }

    public function setTicketFee($ticketFee) {
        $this->ticketFee = $ticketFee;

        return $this;
    }

    public function getCurrencyCcy() {
        return $this->currencyCcy;
    }

    public function setCurrencyCcy($currencyCcy) {
        $this->currencyCcy = $currencyCcy;

        return $this;
    }

    public function getCurrencySymbol() {
        return $this->currencySymbol;
    }

    public function setCurrencySymbol($currencySymbol) {
        $this->currencySymbol = $currencySymbol;

        return $this;
    }

    public function getTicketPricePercentageCut() {
        return $this->ticketPricePercentageCut;
    }

    public function setTicketPricePercentageCut($ticketPricePercentageCut) {
        $this->ticketPricePercentageCut = $ticketPricePercentageCut;

        return $this;
    }

}
