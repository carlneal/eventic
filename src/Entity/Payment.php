<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Payment as BasePayment;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 * @ORM\Table(name="eventic_payment")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Payment extends BasePayment {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Order")
     * @ORM\JoinColumn(nullable=true)
     */
    private $order;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     *  * @var string
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     *  * @var string
     */
    private $lastname;

    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *  * @var string
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *  * @var string
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *  * @var string
     */
    private $postalcode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *  * @var string
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *  * @var string
     */
    private $street2;

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

    public function hasBillingInformation() {
        return ($this->firstname || $this->lastname || $this->clientEmail || $this->stringifyAddress());
    }

    public function stringifyAddress() {
        $address = "";
        if ($this->street) {
            $address .= $this->street . " ";
        }
        if ($this->street2) {
            $address .= $this->street2 . " ";
        }
        if ($this->city) {
            $address .= $this->city . " ";
        }
        if ($this->postalcode) {
            $address .= $this->postalcode . " ";
        }
        if ($this->state) {
            $address .= $this->state . " ";
        }
        if ($this->country) {
            $address .= $this->country->getName();
        }
        return $address;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    public function getStreet() {
        return $this->street;
    }

    public function setStreet($street) {
        $this->street = $street;

        return $this;
    }

    public function getStreet2() {
        return $this->street2;
    }

    public function setStreet2($street2) {
        $this->street2 = $street2;

        return $this;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;

        return $this;
    }

    public function getPostalcode() {
        return $this->postalcode;
    }

    public function setPostalcode($postalcode) {
        $this->postalcode = $postalcode;

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

    public function getOrder() {
        return $this->order;
    }

    public function setOrder($order) {
        $this->order = $order;

        return $this;
    }

}
