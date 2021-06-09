<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VenueRepository")
 * @ORM\Table(name="eventic_venue")
 * @Assert\Callback({"App\Validation\Validator", "validate"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Venue {

    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Valid()
     */
    protected $translations;

    /**
     * @ORM\OneToMany(targetEntity="EventDate", mappedBy="venue")
     */
    private $eventdates;

    /**
     * @ORM\ManyToOne(targetEntity="Organizer", inversedBy="venues")
     */
    private $organizer;

    /**
     * @ORM\ManyToOne(targetEntity="VenueType", inversedBy="venues")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="VenueImage", mappedBy="venue", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="Amenity", inversedBy="venues", cascade={"persist", "merge", "remove"})
     * @ORM\JoinTable(name="eventic_venue_amenity",
     *   joinColumns={@ORM\JoinColumn(name="Venue_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="Amenity_Id", referencedColumnName="id")}
     * )
     */
    private $amenities;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $seatedguests;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $standingguests;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(max = 100)
     */
    private $neighborhoods;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\Length(max = 500)
     */
    private $foodbeverage;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\Length(max = 500)
     */
    private $pricing;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\Length(max = 500)
     */
    private $availibility;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $hidden = false;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $showmap = true;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $quoteform = true;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min = 2, max = 50)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(max = 50)
     */
    private $street2;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min = 2, max = 50)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min = 2, max = 50)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=15, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min = 2, max = 15)
     */
    private $postalcode;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="venues")
     * @Assert\NotNull
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lng;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $listedondirectory = true;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(max = 50)
     */
    private $contactemail;

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
        $this->amenities = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->eventdates = new ArrayCollection();
    }

    public function __call($method, $arguments) {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function stringifyAddress() {
        $address = $this->street;
        if ($this->street2 != "" && $this->street2 != null) {
            $address .= ', ' . $this->street2;
        }
        $address .= $this->postalcode . ' ' . $this->city . ', ' . $this->state . ', ' . $this->country->getName();
        return $address;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->translate()->getName();
    }

    public function getDescription() {
        return $this->translate()->getDescription();
    }

    public function getUpdatedAt() {
        return $this->updatedAt == $this->createdAt ? null : $this->updatedAt;
    }

    public function getHidden() {
        return $this->hidden;
    }

    public function setHidden($hidden) {
        $this->hidden = $hidden;

        return $this;
    }

    public function getListedondirectory() {
        return $this->listedondirectory;
    }

    public function setListedondirectory($listedondirectory) {
        $this->listedondirectory = $listedondirectory;

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

    public function getShowmap() {
        return $this->showmap;
    }

    public function setShowmap($showmap) {
        $this->showmap = $showmap;

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

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Amenity[]
     */
    public function getAmenities() {
        return $this->amenities;
    }

    public function addAmenity($amenity) {
        if (!$this->amenities->contains($amenity)) {
            $this->amenities[] = $amenity;
        }

        return $this;
    }

    public function removeAmenity($amenity) {
        if ($this->amenities->contains($amenity)) {
            $this->amenities->removeElement($amenity);
        }

        return $this;
    }

    public function getSeatedguests() {
        return $this->seatedguests;
    }

    public function setSeatedguests($seatedguests) {
        $this->seatedguests = $seatedguests;

        return $this;
    }

    public function getStandingguests() {
        return $this->standingguests;
    }

    public function setStandingguests($standingguests) {
        $this->standingguests = $standingguests;

        return $this;
    }

    public function getNeighborhoods() {
        return $this->neighborhoods;
    }

    public function setNeighborhoods($neighborhoods) {
        $this->neighborhoods = $neighborhoods;

        return $this;
    }

    public function getPricing() {
        return $this->pricing;
    }

    public function setPricing($pricing) {
        $this->pricing = $pricing;

        return $this;
    }

    public function getAvailibility() {
        return $this->availibility;
    }

    public function setAvailibility($availibility) {
        $this->availibility = $availibility;

        return $this;
    }

    public function getFoodbeverage() {
        return $this->foodbeverage;
    }

    public function setFoodbeverage($foodbeverage) {
        $this->foodbeverage = $foodbeverage;

        return $this;
    }

    /**
     * @return Collection|VenueImage[]
     */
    public function getImages() {
        return $this->images;
    }

    public function addImage($image) {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setVenue($this);
        }

        return $this;
    }

    public function removeImage($image) {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
// set the owning side to null (unless already changed)
            if ($image->getVenue() === $this) {
                $image->setVenue(null);
            }
        }

        return $this;
    }

    public function getImagePlaceholder($size = "default") {
        if ($size == "small") {
            return "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAABGCAMAAABG8BK2AAAAS1BMVEUAAAD2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhGpYChqAAAAGHRSTlMAAgYHDyMmKT9JTlFSVVaAhZ2oqq3g+/1i504YAAAAwklEQVRYw+2XQQ7CIBREx1aLFkRtFef+J3UBERtNAMUF+t9mNuSFMJDwAUH4NTYXprmeVglNjoXkNqHJs1CnNWebIE9jkV7TpEZZ0wPojVUxOh8FGkcaAIZ0MUYfBZoQlmQM7aNAM9EpAMpxijH4gBQuhf9T4YMeOwDdqIenkMKlcCm89cIracIRLyk/4pebKi88XL8l5dcvPIb14RjYvfUYAvv49/ykKSuar2hmfWd+mBIieZoao0elQajSWCYI7XEDcpBQF5AyIN0AAAAASUVORK5CYII=";
        } else {
            return "data:image/png;base64,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";
        }
    }

    public function getFirstImageOrPlaceholder() {
        if (count($this->images) > 0) {
            return $this->images[0]->getImagePath();
        } else {
            return $this->getImagePlaceholder();
        }
    }

    public function getOrganizer() {
        return $this->organizer;
    }

    public function setOrganizer($organizer) {
        $this->organizer = $organizer;

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
            $eventdate->setVenue($this);
        }

        return $this;
    }

    public function removeEventdate($eventdate) {
        if ($this->eventdates->contains($eventdate)) {
            $this->eventdates->removeElement($eventdate);
// set the owning side to null (unless already changed)
            if ($eventdate->getVenue() === $this) {
                $eventdate->setVenue(null);
            }
        }

        return $this;
    }

    public function getContactemail() {
        return $this->contactemail;
    }

    public function setContactemail($contactemail) {
        $this->contactemail = $contactemail;

        return $this;
    }

    public function getQuoteform() {
        return $this->quoteform;
    }

    public function setQuoteform($quoteform) {
        $this->quoteform = $quoteform;

        return $this;
    }

    public function getLat() {
        return $this->lat;
    }

    public function setLat($lat) {
        $this->lat = $lat;

        return $this;
    }

    public function getLng() {
        return $this->lng;
    }

    public function setLng($lng) {
        $this->lng = $lng;

        return $this;
    }

}
