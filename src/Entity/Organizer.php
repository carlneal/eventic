<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganizerRepository")
 * @ORM\Table(name="eventic_organizer")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @Vich\Uploadable
 */
class Organizer {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Venue", mappedBy="organizer", cascade={"remove"})
     */
    private $venues;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="organizer", cascade={"remove"})
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="Scanner", mappedBy="organizer", cascade={"remove"})
     */
    private $scanners;

    /**
     * @ORM\OneToMany(targetEntity="PointOfSale", mappedBy="organizer", cascade={"remove"})
     */
    private $pointofsales;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="organizers", cascade={"persist", "merge", "remove"})
     * @ORM\JoinTable(name="eventic_organizer_category",
     *   joinColumns={@ORM\JoinColumn(name="Organizer_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="Category_Id", referencedColumnName="id")}
     * )
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="following", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="eventic_following",
     *   joinColumns={@ORM\JoinColumn(name="Organizer_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="User_Id", referencedColumnName="id")}
     * )
     */
    private $followedby;

    /**
     * @ORM\OneToMany(targetEntity="PayoutRequest", mappedBy="organizer", cascade={"remove"})
     */
    private $payoutRequests;

    /**
     * @ORM\OneToMany(targetEntity="PaymentGateway", mappedBy="organizer", cascade={"remove"})
     */
    private $paymentGateways;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank
     * @Assert\Length(min = 2, max = 25)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=true)
     * @ORM\Column(length=35, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     * @Assert\Length(max = 1000)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="organizers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(max = 50)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(max = 50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(min = 1, max = 50)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max = 100)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max = 100)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max = 100)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max = 100)
     */
    private $googleplus;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max = 100)
     */
    private $linkedin;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    private $youtubeurl;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="organizer_logo", fileNameProperty="logoName", size="logoSize", mimeType="logoMimeType", originalName="logoOriginalName", dimensions="logoDimensions")
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png"},
     *     mimeTypesMessage = "The file should be an image"
     *     )
     * @var File
     */
    private $logoFile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $logoName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $logoSize;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $logoMimeType;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $logoOriginalName;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $logoDimensions;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="organizer_cover", fileNameProperty="coverName", size="coverSize", mimeType="coverMimeType", originalName="coverOriginalName", dimensions="coverDimensions")
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png"},
     *     mimeTypesMessage = "The file should be an image"
     *     )
     * @var File
     */
    private $coverFile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $coverName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $coverSize;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $coverMimeType;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $coverOriginalName;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $coverDimensions;

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

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $views;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $showvenuesmap = true;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $showfollowers = true;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $showreviews = true;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showEventDateStatsOnScannerApp;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $allowTapToCheckInOnScannerApp;

    public function __construct() {
        $this->events = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->venues = new ArrayCollection();
        $this->scanners = new ArrayCollection();
        $this->pointofsales = new ArrayCollection();
        $this->followedby = new ArrayCollection();
        $this->views = 0;
        $this->showvenuesmap = true;
        $this->showfollowers = true;
        $this->showreviews = true;
        $this->showEventDateStatsOnScannerApp = true;
        $this->allowTapToCheckInOnScannerApp = true;
        $this->payoutRequests = new ArrayCollection();
        $this->paymentGateways = new ArrayCollection();
    }

    public function displayCategories() {
        $categories = "";
        foreach ($this->categories as $category) {
            $categories .= $category->getName() . ", ";
        }
        return rtrim($categories, ", ");
    }

    public function isFollowedBy($user) {
        return $this->followedby->contains($user);
    }

    public function hasSocialMedia() {
        return ($this->website || $this->email || $this->phone || $this->twitter || $this->instagram || $this->facebook || $this->googleplus || $this->linkedin);
    }

    public function viewed() {
        $this->views = $this->views++;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $logoFile
     */
    public function setLogoFile(File $logoFile = null) {
        $this->logoFile = $logoFile;

        if (null !== $logoFile) {
// It is required that at least one field changes if you are using doctrine
// otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getLogoFile() {
        return $this->logoFile;
    }

    public function getLogoPath() {
        return 'uploads/organizers/' . $this->logoName;
    }

    public function getLogoPlaceholder($size = "default") {
        if ($size == "small") {
            return "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAABGCAMAAABG8BK2AAAA4VBMVEUAAAD2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhFAEufoAAAASnRSTlMAAQIDBAUGBwkNDg8QERMUGx0fICUmKi04PT9BQ0ZHSUpMTVZXWVtiZGZndHV5e3+FiImMkZSanaOlsLK3ytPa3N7i6On19/n7/X4N0FUAAAFVSURBVFjD7ddpT8IwAAbglolDRQ4PwGMqHrTWA9AhTgERdWj//w9yCyauYe16LCTK3o99mydp2i4dAFmy/Mfkz4LUYopaWORlmSIN0o4p2mFRXFpm8wThTjh7iOczDIsORs5agnJD5XIpVK4kFbGzIa1QKljXsQLj8BmkwCA+gxUYrMb4g4eBb8qM6jAYh/WREdPL/TS5ngHzGOk8beYj+mlZ9XUZ9qQSXabClBVdpsCUBV3GZkpblykxZUmXaTJlU5d5gZEOjrWPH+Hvt9Jl+F3WKTVgaHe2W3aXGjGUei2n5cWMKzK8LD3zRBrV8nq52iDPuszn3Y4V6azd+y91ZnxgzdUrh6+KzDmMnQAvVJjpFnfK9lSe2eNPAfvSzBsQ5V2W6QuZvizjChl3wczEFWWyqDuV0msrpbdfSi9RcC2tECDKbSrK7J8hKego6Z8hS5Y/mG9fd7+lNzcPFwAAAABJRU5ErkJggg==";
        } else {
            return "data:image/png;base64,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";
        }
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $logoFile
     */
    public function setCoverFile(File $coverFile = null) {
        $this->coverFile = $coverFile;

        if (null !== $coverFile) {
// It is required that at least one field changes if you are using doctrine
// otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getCoverFile() {
        return $this->coverFile;
    }

    public function getCoverPath() {
        return 'uploads/organizers/covers/' . $this->coverName;
    }

    public function getId() {
        return $this->id;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents() {
        return $this->events;
    }

    public function addEvent($event) {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setOrganizer($this);
        }

        return $this;
    }

    public function removeEvent($event) {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
// set the owning side to null (unless already changed)
            if ($event->getOrganizer() === $this) {
                $event->setOrganizer(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt == $this->createdAt ? null : $this->updatedAt;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;

        return $this;
    }

    public function getLogoName() {
        return $this->logoName;
    }

    public function setLogoName($logoName) {
        $this->logoName = $logoName;

        return $this;
    }

    public function getLogoSize() {
        return $this->logoSize;
    }

    public function setLogoSize($logoSize) {
        $this->logoSize = $logoSize;

        return $this;
    }

    public function getLogoMimeType() {
        return $this->logoMimeType;
    }

    public function setLogoMimeType($logoMimeType) {
        $this->logoMimeType = $logoMimeType;

        return $this;
    }

    public function getLogoOriginalName() {
        return $this->logoOriginalName;
    }

    public function setLogoOriginalName($logoOriginalName) {
        $this->logoOriginalName = $logoOriginalName;

        return $this;
    }

    public function getLogoDimensions() {
        return $this->logoDimensions;
    }

    public function setLogoDimensions($logoDimensions) {
        $this->logoDimensions = $logoDimensions;

        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
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

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories() {
        return $this->categories;
    }

    public function addCategory($category) {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory($category) {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|Venue[]
     */
    public function getVenues() {
        return $this->venues;
    }

    public function addVenue($venue) {
        if (!$this->venues->contains($venue)) {
            $this->venues[] = $venue;
            $venue->setOrganizer($this);
        }

        return $this;
    }

    public function removeVenue($venue) {
        if ($this->venues->contains($venue)) {
            $this->venues->removeElement($venue);
// set the owning side to null (unless already changed)
            if ($venue->getOrganizer() === $this) {
                $venue->setOrganizer(null);
            }
        }

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
     * @return Collection|Scanner[]
     */
    public function getScanners() {
        return $this->scanners;
    }

    public function addScanner($scanner) {
        if (!$this->scanners->contains($scanner)) {
            $this->scanners[] = $scanner;
            $scanner->setOrganizer($this);
        }

        return $this;
    }

    public function removeScanner($scanner) {
        if ($this->scanners->contains($scanner)) {
            $this->scanners->removeElement($scanner);
// set the owning side to null (unless already changed)
            if ($scanner->getOrganizer() === $this) {
                $scanner->setOrganizer(null);
            }
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
            $pointofsale->setOrganizer($this);
        }

        return $this;
    }

    public function removePointofsale($pointofsale) {
        if ($this->pointofsales->contains($pointofsale)) {
            $this->pointofsales->removeElement($pointofsale);
// set the owning side to null (unless already changed)
            if ($pointofsale->getOrganizer() === $this) {
                $pointofsale->setOrganizer(null);
            }
        }

        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function setWebsite($website) {
        $this->website = $website;

        return $this;
    }

    public function getFacebook() {
        return $this->facebook;
    }

    public function setFacebook($facebook) {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter() {
        return $this->twitter;
    }

    public function setTwitter($twitter) {
        $this->twitter = $twitter;

        return $this;
    }

    public function getInstagram() {
        return $this->instagram;
    }

    public function setInstagram($instagram) {
        $this->instagram = $instagram;

        return $this;
    }

    public function getGoogleplus() {
        return $this->googleplus;
    }

    public function setGoogleplus($googleplus) {
        $this->googleplus = $googleplus;

        return $this;
    }

    public function getLinkedin() {
        return $this->linkedin;
    }

    public function setLinkedin($linkedin) {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getYoutubeurl() {
        return $this->youtubeurl;
    }

    public function setYoutubeurl($youtubeurl) {
        $this->youtubeurl = $youtubeurl;

        return $this;
    }

    public function getCoverName() {
        return $this->coverName;
    }

    public function setCoverName($coverName) {
        $this->coverName = $coverName;

        return $this;
    }

    public function getCoverSize() {
        return $this->coverSize;
    }

    public function setCoverSize($coverSize) {
        $this->coverSize = $coverSize;

        return $this;
    }

    public function getCoverMimeType() {
        return $this->coverMimeType;
    }

    public function setCoverMimeType($coverMimeType) {
        $this->coverMimeType = $coverMimeType;

        return $this;
    }

    public function getCoverOriginalName() {
        return $this->coverOriginalName;
    }

    public function setCoverOriginalName($coverOriginalName) {
        $this->coverOriginalName = $coverOriginalName;

        return $this;
    }

    public function getCoverDimensions() {
        return $this->coverDimensions;
    }

    public function setCoverDimensions($coverDimensions) {
        $this->coverDimensions = $coverDimensions;

        return $this;
    }

    public function getViews() {
        return $this->views;
    }

    public function setViews($views) {
        $this->views = $views;

        return $this;
    }

    public function getShowvenuesmap() {
        return $this->showvenuesmap;
    }

    public function setShowvenuesmap($showvenuesmap) {
        $this->showvenuesmap = $showvenuesmap;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFollowedby() {
        return $this->followedby;
    }

    public function addFollowedby($followedby) {
        if (!$this->followedby->contains($followedby)) {
            $this->followedby[] = $followedby;
        }

        return $this;
    }

    public function removeFollowedby($followedby) {
        if ($this->followedby->contains($followedby)) {
            $this->followedby->removeElement($followedby);
        }

        return $this;
    }

    public function getShowfollowers() {
        return $this->showfollowers;
    }

    public function setShowfollowers($showfollowers) {
        $this->showfollowers = $showfollowers;

        return $this;
    }

    public function getShowreviews() {
        return $this->showreviews;
    }

    public function setShowreviews($showreviews) {
        $this->showreviews = $showreviews;

        return $this;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    public function getShowEventDateStatsOnScannerApp() {
        return $this->showEventDateStatsOnScannerApp;
    }

    public function setShowEventDateStatsOnScannerApp($showEventDateStatsOnScannerApp) {
        $this->showEventDateStatsOnScannerApp = $showEventDateStatsOnScannerApp;

        return $this;
    }

    public function getAllowTapToCheckInOnScannerApp() {
        return $this->allowTapToCheckInOnScannerApp;
    }

    public function setAllowTapToCheckInOnScannerApp($allowTapToCheckInOnScannerApp) {
        $this->allowTapToCheckInOnScannerApp = $allowTapToCheckInOnScannerApp;

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
            $payoutRequest->setOrganizer($this);
        }

        return $this;
    }

    public function removePayoutRequest($payoutRequest) {
        if ($this->payoutRequests->contains($payoutRequest)) {
            $this->payoutRequests->removeElement($payoutRequest);
// set the owning side to null (unless already changed)
            if ($payoutRequest->getOrganizer() === $this) {
                $payoutRequest->setOrganizer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PaymentGateway[]
     */
    public function getPaymentGateways() {
        return $this->paymentGateways;
    }

    public function addPaymentGateway($paymentGateway) {
        if (!$this->paymentGateways->contains($paymentGateway)) {
            $this->paymentGateways[] = $paymentGateway;
            $paymentGateway->setOrganizer($this);
        }

        return $this;
    }

    public function removePaymentGateway($paymentGateway) {
        if ($this->paymentGateways->contains($paymentGateway)) {
            $this->paymentGateways->removeElement($paymentGateway);
// set the owning side to null (unless already changed)
            if ($paymentGateway->getOrganizer() === $this) {
                $paymentGateway->setOrganizer(null);
            }
        }

        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

}
