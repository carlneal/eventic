<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\Table(name="eventic_event")
 * @Assert\Callback({"App\Validation\Validator", "validateEvent"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @Vich\Uploadable
 */
class Event {

    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Valid(groups={"create", "update"})
     */
    protected $translations;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="events")
     * @Assert\NotNull(groups={"create", "update"})
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="Language", inversedBy="events", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="eventic_event_language",
     *   joinColumns={@ORM\JoinColumn(name="Event_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="Language_Id", referencedColumnName="id")}
     * )
     */
    private $languages;

    /**
     * @ORM\ManyToMany(targetEntity="Language", inversedBy="eventssubtitled", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="eventic_event_subtitle",
     *   joinColumns={@ORM\JoinColumn(name="Event_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="Language_Id", referencedColumnName="id")}
     * )
     */
    private $subtitles;

    /**
     * @ORM\ManyToMany(targetEntity="Audience", inversedBy="events", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="eventic_event_audience",
     *   joinColumns={@ORM\JoinColumn(name="Event_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="Audience_Id", referencedColumnName="id")}
     * )
     */
    private $audiences;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="events")
     * @ORM\JoinColumn(nullable=true)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="Organizer", inversedBy="events")
     */
    private $organizer;

    /**
     * @ORM\OneToMany(targetEntity="EventImage", mappedBy="event", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="EventDate", mappedBy="event", cascade={"persist", "remove"}, fetch = "EAGER", orphanRemoval=true)
     * @ORM\OrderBy({"startdate" = "ASC"})
     * @Assert\Valid(groups={"create", "update"})
     */
    private $eventdates;

    /**
     * @ORM\OneToMany(targetEntity="Review", mappedBy="event", cascade={"remove"})
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="favorites", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="eventic_favorites",
     *   joinColumns={@ORM\JoinColumn(name="Event_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="User_Id", referencedColumnName="id")}
     * )
     */
    private $addedtofavoritesby;

    /**
     * @ORM\ManyToOne(targetEntity="HomepageHeroSettings", inversedBy="events", cascade={"persist"})
     */
    private $isonhomepageslider;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $views;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    private $youtubeurl;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    private $externallink;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(max = 50)
     */
    private $phonenumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    private $instagram;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    private $googleplus;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    private $linkedin;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\Length(max = 500)
     */
    private $artists;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\Length(max = 500)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=5, nullable=true)
     * @Assert\Length(max = 5)
     */
    private $year;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="event_image", fileNameProperty="imageName", size="imageSize", mimeType="imageMimeType", originalName="imageOriginalName", dimensions="imageDimensions")
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png"},
     *     mimeTypesMessage = "The file should be an image"
     *     )
     * @Assert\NotNull(groups={"create"})
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $imageMimeType;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $imageOriginalName;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $imageDimensions;

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
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $published = false;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull(groups={"create", "update"})
     */
    private $enablereviews = true;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull(groups={"create", "update"})
     */
    private $showattendees = true;

    public function __construct() {
        $this->languages = new ArrayCollection();
        $this->audiences = new ArrayCollection();
        $this->views = 0;
        $this->eventdates = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->reference = $this->generateReference(10);
        $this->subtitles = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->addedtofavoritesby = new ArrayCollection();
    }

    public function getSales($role = "all", $user = "all", $formattedForPayoutApproval = false, $includeFees = false) {
        $sum = 0;
        foreach ($this->eventdates as $eventDate) {
            $sum += $eventDate->getSales($role, $user, $formattedForPayoutApproval, $includeFees);
        }
        return $sum;
    }

    public function getTicketPricePercentageCutSum($role = "all") {
        $sum = 0;
        foreach ($this->eventdates as $eventDate) {
            $sum += $eventDate->getTicketPricePercentageCutSum($role);
        }
        return $sum;
    }

    public function getTotalOrderElementsQuantitySum($status = 1, $user = "all", $role = "all") {
        $sum = 0;
        foreach ($this->eventdates as $eventDate) {
            $sum += $eventDate->getOrderElementsQuantitySum($status, $user, $role);
        }
        return $sum;
    }

    public function getTotalCheckInPercentage() {
        if (count($this->eventdates) == 0)
            return 0;
        $eventDatesCheckInPercentageSum = 0;
        foreach ($this->eventdates as $eventDate) {
            $eventDatesCheckInPercentageSum += $eventDate->getTotalCheckInPercentage();
        }
        return round($eventDatesCheckInPercentageSum / count($this->eventdates));
    }

    public function getTotalSalesPercentage() {
        if (count($this->eventdates) == 0)
            return 0;
        $eventDatesSalesPercentageSum = 0;
        foreach ($this->eventdates as $eventDate) {
            $eventDatesSalesPercentageSum += $eventDate->getTotalSalesPercentage();
        }
        return round($eventDatesSalesPercentageSum / count($this->eventdates));
    }

    public function isRatedBy($user) {
        foreach ($this->reviews as $review) {
            if ($review->getUser() == $user) {
                return $review;
            }
        }
        return false;
    }

    public function isAddedToFavoritesBy($user) {
        return $this->addedtofavoritesby->contains($user);
    }

    public function stringifyStatus() {
        if (!$this->organizer->getUser()->isEnabled()) {
            return "Organizer is disabled";
        } else if (!$this->published) {
            return "Event is not published";
        } else if (!$this->hasAnEventDateOnSale()) {
            return "No events on sale";
        } else {
            return "On sale";
        }
    }

    public function stringifyStatusClass() {
        if (!$this->organizer->getUser()->isEnabled()) {
            return "danger";
        } else if (!$this->published) {
            return "warning";
        } else if (!$this->hasAnEventDateOnSale()) {
            return "info";
        } else {
            return "success";
        }
    }

    public function isOnSale() {
        return
                $this->hasAnEventDateOnSale() &&
                $this->organizer->getUser()->isEnabled() &&
                $this->published
        ;
    }

    public function hasContactAndSocialMedia() {
        return ($this->externallink || $this->phonenumber || $this->twitter || $this->instagram || $this->email || $this->facebook || $this->googleplus || $this->linkedin);
    }

    public function displayAudiences() {
        $audiences = '';
        if (count($this->audiences) > 0) {
            foreach ($this->audiences as $audience) {
                $audiences .= $audience->getName() . ', ';
            }
        }
        return rtrim($audiences, ', ');
    }

    public function displaySubtitles() {
        $subtitles = '';
        if (count($this->subtitles) > 0) {
            foreach ($this->subtitles as $subtitle) {
                $subtitles .= $subtitle->getName() . ', ';
            }
        }
        return rtrim($subtitles, ', ');
    }

    public function displayLanguages() {
        $languages = '';
        if (count($this->languages) > 0) {
            foreach ($this->languages as $language) {
                $languages .= $language->getName() . ', ';
            }
        }
        return rtrim($languages, ', ');
    }

    public function getRatingsPercentageForRating($rating) {
        if (!$this->countVisibleReviews()) {
            return 0;
        }
        return round(($this->getRatingsCountForRating($rating) / $this->countVisibleReviews()) * 100, 1);
    }

    public function getRatingsCountForRating($rating) {
        if (!$this->countVisibleReviews()) {
            return 0;
        }
        $ratingCount = 0;
        foreach ($this->reviews as $review) {
            if ($review->getVisible() && $review->getRating() == $rating) {
                $ratingCount ++;
            }
        }
        return $ratingCount;
    }

    public function getRatingAvg() {
        if (!$this->countVisibleReviews()) {
            return 0;
        }
        $ratingAvg = 0;
        foreach ($this->reviews as $review) {
            if ($review->getVisible()) {
                $ratingAvg += $review->getRating();
            }
        }
        return round($ratingAvg / $this->countVisibleReviews(), 1);
    }

    public function getRatingPercentage() {
        if (!$this->countVisibleReviews()) {
            return 0;
        }
        $ratingPercentage = 0;
        foreach ($this->reviews as $review) {
            if ($review->getVisible()) {
                $ratingPercentage += $review->getRatingPercentage();
            }
        }
        return round($ratingPercentage / $this->countVisibleReviews(), 1);
    }

    public function countVisibleReviews() {
        $count = 0;
        foreach ($this->reviews as $review) {
            if ($review->getVisible()) {
                $count++;
            }
        }
        return $count;
    }

    public function viewed() {
        $this->views++;
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

    public function getFirstVenue() {
        foreach ($this->eventdates as $date) {
            if ($date->getVenue()) {
                return $date->getVenue();
            }
        }
        return null;
    }

    public function getOrderElementsQuantitySum($status = 1) {
        $sum = 0;
        foreach ($this->eventdates as $eventdate) {
            $sum += $eventdate->getOrderElementsQuantitySum($status);
        }
        return $sum;
    }

    public function hasTwoOrMoreEventDatesOnSale() {
        $count = 0;
        foreach ($this->eventdates as $eventdate) {
            if ($eventdate->isOnSale()) {
                $count++;
            }
        }
        return $count >= 2 ? true : false;
    }

    public function hasAnEventDateOnSale() {
        foreach ($this->eventdates as $eventdate) {
            if ($eventdate->isOnSale()) {
                return true;
            }
        }
        return false;
    }

    public function getFirstOnSaleEventDate() {
        foreach ($this->eventdates as $eventdate) {
            if ($eventdate->isOnSale()) {
                return $eventdate;
            }
        }
        return null;
    }

    public function isFree() {
        foreach ($this->eventdates as $eventdate) {
            if (!$eventdate->isFree()) {
                return false;
            }
        }
        return true;
    }

    public function getCheapestTicket() {
        if (!$this->hasAnEventDateOnSale())
            return null;
        $cheapestticket = $this->getFirstOnSaleEventDate()->getCheapestTicket();
        foreach ($this->eventdates as $eventdate) {
            if ($eventdate->isOnSale()) {
                if ($eventdate->getCheapestTicket()->getSalePrice() < $cheapestticket->getSalePrice()) {
                    $cheapestticket = $eventdate->getCheapestTicket();
                }
            }
        }
        return $cheapestticket;
    }

    public function __call($method, $arguments) {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->translate()->getName();
    }

    public function getSlug() {
        return $this->translate()->getSlug();
    }

    public function getDescription() {
        return $this->translate()->getDescription();
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
    public function setImageFile(File $imageFile = null) {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
// It is required that at least one field changes if you are using doctrine
// otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile() {
        return $this->imageFile;
    }

    public function getImagePath() {
        return 'uploads/events/' . $this->imageName;
    }

    public function getImagePlaceholder($size = "default") {
        if ($size == "small") {
            return "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAABGCAMAAABG8BK2AAAAXVBMVEUAAAD2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhHkayjUAAAAHnRSTlMABQ0PEBEcKixARkdJSk1WYmRmZ3R1eHl7f4WjsMpiv/ZRAAAAtUlEQVRYw+3X2Q7CIBCFYVqRLmoH3Oly3v8xvfCiJrYsSjRp578l+RJIIIMQHLfEMiKiYmKhICLKQhkJAHZiwQKAXC2zPWjTAsBg3hsAoDW6zj3KDWEdncoZSOBsEJ5jX/sIpp5ndASj5xkTwRhm/s101lcXwijv9VXMMPMzRlZj5edM9XKTemaYWTNT9mNXfm++YzQANMpX45m2Es1+iSZRcQlWTs7TuydRnn8GX3qXC45bXA+ADIuZ4XkIYQAAAABJRU5ErkJggg==";
        } else {
            return "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAV4AAAFeCAMAAAD69YcoAAAA9lBMVEUAAAD2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhEZWD6+AAAAUXRSTlMAAQIDBAYJDQ4QExQVFhcYGhseHyAhKi0uLzAxMjQ6Ozw+P0BERUZHSUpPUVVWV1hZYmRmcXN0dYOFiYuXmJq3ur7HyNHT1dfZ3Obo8fX3+fvgzUWiAAADeklEQVR42u3cSVNTQRSA0RcBgQhOKCg4MImoJPKCA+BAQGVUof//n3Gpm7iQCt3ver51qjo5i5fu26lUlSRJkiRJkiRJkiRJkiRJkiRJkiRJkiRJkiRdVdc/DGjrChbfGrT49Si8k2lA+1ew+P6gxSfx4sWLFy9evHjx4sWLFy9evHjx4sWLFy9evHjx4sWLFy9evHjHbj5a79S93+0M+oSnveF3OmjxnT9eVG+szbWvNcD23puj1NT2OuNF246+PkvNrj9bLG6r+yM1v4O7Zere/ppitD1SoO7LFKbjdnG6uylQF/OFPXY/pVitFsX7MSW+Q+tdilc5z4enAXXTRSnfbxPnEXnTcSH7s36K2XYRuk9S1Eo4v7XOwvIeFMC7nOJWwHznMDBvP7vuVIpc9vlvLzRvJzfvQWjevdz3Eyl2me/fpoPzZj4ZzwfnncvLux6cdy0vbzc470Ze3jo4b23bO8x6ePHixYsXL168ePHixYsXL168ePHixYsXL168ePHixYsXL168ePHixYsXL168ePHixYsXL168/8J7st+kTprGu1g1qUW8ePHixYsXL168ePHixYsXL168ePHixYsXL168ePHixYsXL168ePHixYsXL168ePHixYsXL168ePHixYsXL168ePHixYsXL168eIfQ5MplWsL791Yu9c8453jx4sWLFy9evHjx4sWLFy9evHjx4sWLFy9evHjx4sWLFy9evHjx4sWLFy9evHjx4sWLFy9evHjx4sWLFy9evHjx4sWLFy9evHjx4sWLFy9evHjx4sWLFy9evHjxNp136fwyfcebJbx48eLFixcvXrx48eLFixcvXrx48eLFixcvXrx48eLFixfvf8BbD3pfu4tNanfQx6jz8nZT7Dby8q4H513LyzsfnPdBXt7p4LztvLyjwXmvZd7SfAmtu5d7x9gLzdvJzTsVmnc8+4HnMLBuP/95cjkw72x+3tZZWN0vJYxDnoblnSli3NQPqrtTxjRv4jyk7vFI6dPSJnfRrkrpfUDehYKm/Z/C6a6WdJnS+hxM91lht1UfQj13F6rSehVoz9CuyuvOtyj73ZGqxFqbPyOchGeqUhvdbPoAoj9bFd39t0fNte1ONOAnL2O3Hr/o1r0mVXeeP7wxUkmSJEmSJEmSJEmSJEmSJEmSJEmSJEmSJEnSsPoFIVJb/voL1VsAAAAASUVORK5CYII=";
        }
    }

    public function getUpdatedAt() {
        return $this->updatedAt == $this->createdAt ? null : $this->updatedAt;
    }

    public function getCategory() {
        return $this->category;
    }

    public function setCategory(Category $category) {
        $this->category = $category;

        return $this;
    }

    public function getOrganizer() {
        return $this->organizer;
    }

    public function setOrganizer(Organizer $organizer) {
        $this->organizer = $organizer;

        return $this;
    }

    public function getImageName() {
        return $this->imageName;
    }

    public function setImageName($imageName) {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageSize() {
        return $this->imageSize;
    }

    public function setImageSize($imageSize) {
        $this->imageSize = $imageSize;

        return $this;
    }

    public function getImageMimeType() {
        return $this->imageMimeType;
    }

    public function setImageMimeType($imageMimeType) {
        $this->imageMimeType = $imageMimeType;

        return $this;
    }

    public function getImageOriginalName() {
        return $this->imageOriginalName;
    }

    public function setImageOriginalName($imageOriginalName) {
        $this->imageOriginalName = $imageOriginalName;

        return $this;
    }

    public function getImageDimensions() {
        return $this->imageDimensions;
    }

    public function setImageDimensions($imageDimensions) {
        $this->imageDimensions = $imageDimensions;

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

    public function getPublished() {
        return $this->published;
    }

    public function setPublished($published) {
        $this->published = $published;

        return $this;
    }

    /**
     * @return Collection|Language[]
     */
    public function getLanguages() {
        return $this->languages;
    }

    public function addLanguage($language) {
        if (!$this->languages->contains($language)) {
            $this->languages[] = $language;
        }

        return $this;
    }

    public function removeLanguage($language) {
        if ($this->languages->contains($language)) {
            $this->languages->removeElement($language);
        }

        return $this;
    }

    /**
     * @return Collection|Audience[]
     */
    public function getAudiences() {
        return $this->audiences;
    }

    public function addAudience($audience) {
        if (!$this->audiences->contains($audience)) {
            $this->audiences[] = $audience;
        }

        return $this;
    }

    public function removeAudience($audience) {
        if ($this->audiences->contains($audience)) {
            $this->audiences->removeElement($audience);
        }

        return $this;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;

        return $this;
    }

    public function getViews() {
        return $this->views;
    }

    public function setViews($views) {
        $this->views = $views;

        return $this;
    }

    public function getYoutubeurl() {
        return $this->youtubeurl;
    }

    public function setYoutubeurl($youtubeurl) {
        $this->youtubeurl = $youtubeurl;

        return $this;
    }

    public function getExternallink() {
        return $this->externallink;
    }

    public function setExternallink($externallink) {
        $this->externallink = $externallink;

        return $this;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection|EventDate[]
     */
    public function getEventdates() {
        return $this->eventdates;
    }

    public function addEventdate($eventdate) {
        if (!$this->eventdates->contains($eventdate)) {
            $this->eventdates[] = $eventdate;
            $eventdate->setEvent($this);
        }

        return $this;
    }

    public function removeEventdate($eventdate) {
        if ($this->eventdates->contains($eventdate)) {
            $this->eventdates->removeElement($eventdate);
// set the owning side to null (unless already changed)
            if ($eventdate->getEvent() === $this) {
                $eventdate->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EventImage[]
     */
    public function getImages() {
        return $this->images;
    }

    public function addImage($image) {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setEvent($this);
        }

        return $this;
    }

    public function removeImage($image) {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
// set the owning side to null (unless already changed)
            if ($image->getEvent() === $this) {
                $image->setEvent(null);
            }
        }

        return $this;
    }

    public function getArtists() {
        return $this->artists;
    }

    public function setArtists($artists) {
        $this->artists = $artists;

        return $this;
    }

    public function getTags() {
        return $this->tags;
    }

    public function setTags($tags) {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return Collection|Language[]
     */
    public function getSubtitles() {
        return $this->subtitles;
    }

    public function addSubtitle($subtitle) {
        if (!$this->subtitles->contains($subtitle)) {
            $this->subtitles[] = $subtitle;
        }

        return $this;
    }

    public function removeSubtitle($subtitle) {
        if ($this->subtitles->contains($subtitle)) {
            $this->subtitles->removeElement($subtitle);
        }

        return $this;
    }

    public function getYear() {
        return $this->year;
    }

    public function setYear($year) {
        $this->year = $year;

        return $this;
    }

    public function getPhonenumber() {
        return $this->phonenumber;
    }

    public function setPhonenumber($phonenumber) {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;

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

    public function getFacebook() {
        return $this->facebook;
    }

    public function setFacebook($facebook) {
        $this->facebook = $facebook;

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

    public function getShowattendees() {
        return $this->showattendees;
    }

    public function setShowattendees($showattendees) {
        $this->showattendees = $showattendees;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews() {
        return $this->reviews;
    }

    public function addReview($review) {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setEvent($this);
        }

        return $this;
    }

    public function removeReview($review) {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
// set the owning side to null (unless already changed)
            if ($review->getEvent() === $this) {
                $review->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAddedtofavoritesby() {
        return $this->addedtofavoritesby;
    }

    public function addAddedtofavoritesby($addedtofavoritesby) {
        if (!$this->addedtofavoritesby->contains($addedtofavoritesby)) {
            $this->addedtofavoritesby[] = $addedtofavoritesby;
        }

        return $this;
    }

    public function removeAddedtofavoritesby($addedtofavoritesby) {
        if ($this->addedtofavoritesby->contains($addedtofavoritesby)) {
            $this->addedtofavoritesby->removeElement($addedtofavoritesby);
        }

        return $this;
    }

    public function getEnablereviews() {
        return $this->enablereviews;
    }

    public function setEnablereviews($enablereviews) {
        $this->enablereviews = $enablereviews;

        return $this;
    }

    public function getIsonhomepageslider() {
        return $this->isonhomepageslider;
    }

    public function setIsonhomepageslider($isonhomepageslider) {
        $this->isonhomepageslider = $isonhomepageslider;

        return $this;
    }

}
