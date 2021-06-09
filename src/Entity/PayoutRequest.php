<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PayoutRequestRepository")
 * @ORM\Table(name="eventic_payout_request")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class PayoutRequest {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Organizer", inversedBy="payoutRequests")
     */
    private $organizer;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentGateway", inversedBy="payoutRequests", fetch="EAGER")
     * @ORM\JoinColumn(nullable=true)
     */
    private $paymentGateway;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $payment;

    /**
     * @ORM\ManyToOne(targetEntity="EventDate", inversedBy="payoutRequests")
     */
    private $eventDate;

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
     * -2: failed (by the organizer) / -1: canceled (by the organizer) / 0: pending / 1: approved (by the administrator)
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $status;

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
        $this->reference = $this->generateReference(15);
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
                return "Pending";
                break;
            case 1:
                return "Approved";
                break;
            default:
                return "Unknown";
        }
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;

        return $this;
    }

    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;

        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;

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

    public function getOrganizer() {
        return $this->organizer;
    }

    public function setOrganizer($organizer) {
        $this->organizer = $organizer;

        return $this;
    }

    public function getPaymentGateway() {
        return $this->paymentGateway;
    }

    public function setPaymentGateway($paymentGateway) {
        $this->paymentGateway = $paymentGateway;

        return $this;
    }

    public function getDeletedAt() {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getEventDate() {
        return $this->eventDate;
    }

    public function setEventDate($eventDate) {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getPayment() {
        return $this->payment;
    }

    public function setPayment($payment) {
        $this->payment = $payment;

        return $this;
    }

}
