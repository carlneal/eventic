<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\GatewayConfig as BaseGatewayConfig;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Payum\Core\Security\CypherInterface;

/**
 * @ORM\Table(name="eventic_payment_gateway")
 * @ORM\Entity(repositoryClass="App\Repository\PaymentGatewayRepository")
 * @Vich\Uploadable
 */
class PaymentGateway extends BaseGatewayConfig {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="paymentgateway")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="PayoutRequest", mappedBy="paymentGateway")
     */
    private $payoutRequests;

    /**
     * @ORM\ManyToOne(targetEntity="Organizer", inversedBy="paymentGateways")
     * @ORM\JoinColumn(nullable=true)
     */
    private $organizer;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Length(min = 1, max = 50)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=true)
     * @ORM\Column(length=70, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $gatewayLogoName;

    /**
     * @Vich\UploadableField(mapping="payment_gateway", fileNameProperty="gatewayLogoName")
     * @var File
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png"},
     *     mimeTypesMessage = "The file should be an image"
     *     )
     * @Assert\NotNull(groups={"create"})
     */
    private $gatewayLogoFile;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $enabled = true;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(groups={"create", "update"})
     *
     * @var integer
     */
    private $number;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct() {
        parent::__construct();
        $this->orders = new ArrayCollection();
        $this->payoutRequests = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt(CypherInterface $cypher) {
        if (empty($this->config['encrypted'])) {
            return;
        }

        foreach ($this->config as $name => $value) {
            if ('encrypted' == $name || is_bool($value) || $value === null) {
                $this->decryptedConfig[$name] = $value;

                continue;
            }

            $this->decryptedConfig[$name] = $cypher->decrypt($value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt(CypherInterface $cypher) {
        $this->decryptedConfig['encrypted'] = true;

        foreach ($this->decryptedConfig as $name => $value) {
            if ('encrypted' == $name || is_bool($value) || $value === null) {
                $this->config[$name] = $value;

                continue;
            }

            $this->config[$name] = $cypher->encrypt($value);
        }
    }

    public function getLogoPath() {
        return 'uploads/payment/gateways/' . $this->gatewayLogoName;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setGatewayLogoFile(File $imageFile = null) {
        $this->gatewayLogoFile = $imageFile;

        if (null !== $imageFile) {
// It is required that at least one field changes if you are using doctrine
// otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getGatewayLogoFile() {
        return $this->gatewayLogoFile;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    public function getGatewayLogoName() {
        return $this->gatewayLogoName;
    }

    public function setGatewayLogoName($gatewayLogoName) {
        $this->gatewayLogoName = $gatewayLogoName;

        return $this;
    }

    public function getEnabled() {
        return $this->enabled;
    }

    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        $this->number = $number;

        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders() {
        return $this->orders;
    }

    public function addOrder($order) {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setPaymentgateway($this);
        }

        return $this;
    }

    public function removeOrder($order) {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
// set the owning side to null (unless already changed)
            if ($order->getPaymentgateway() === $this) {
                $order->setPaymentgateway(null);
            }
        }

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
            $payoutRequest->setPaymentGateway($this);
        }

        return $this;
    }

    public function removePayoutRequest($payoutRequest) {
        if ($this->payoutRequests->contains($payoutRequest)) {
            $this->payoutRequests->removeElement($payoutRequest);
// set the owning side to null (unless already changed)
            if ($payoutRequest->getPaymentGateway() === $this) {
                $payoutRequest->setPaymentGateway(null);
            }
        }

        return $this;
    }

    public function getOrganizer() {
        return $this->organizer;
    }

    public function setOrganizer($organizer) {
        $this->organizer = $organizer;

        return $this;
    }

}
