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
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 * @ORM\Table(name="eventic_country")
 * @Assert\Callback({"App\Validation\Validator", "validate"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Country {

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
     * @ORM\OneToMany(targetEntity="Venue", mappedBy="country")
     */
    private $venues;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="country")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="Organizer", mappedBy="country")
     */
    private $organizers;

    /**
     * @ORM\Column(type="string", length=2, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min = 2, max = 2)
     */
    protected $code;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $hidden = false;

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
        $this->events = new ArrayCollection();
        $this->venues = new ArrayCollection();
        $this->organizers = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function __toString() {
        return $this->getName();
    }

    public function __call($method, $arguments) {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function getName() {
        return $this->translate()->getName();
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

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;

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
            $venue->setCountry($this);
        }

        return $this;
    }

    public function removeVenue($venue) {
        if ($this->venues->contains($venue)) {
            $this->venues->removeElement($venue);
// set the owning side to null (unless already changed)
            if ($venue->getCountry() === $this) {
                $venue->setCountry(null);
            }
        }

        return $this;
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
            $event->setCountry($this);
        }

        return $this;
    }

    public function removeEvent($event) {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
// set the owning side to null (unless already changed)
            if ($event->getCountry() === $this) {
                $event->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Organizer[]
     */
    public function getOrganizers() {
        return $this->organizers;
    }

    public function addOrganizer($organizer) {
        if (!$this->organizers->contains($organizer)) {
            $this->organizers[] = $organizer;
            $organizer->setCountry($this);
        }

        return $this;
    }

    public function removeOrganizer($organizer) {
        if ($this->organizers->contains($organizer)) {
            $this->organizers->removeElement($organizer);
// set the owning side to null (unless already changed)
            if ($organizer->getCountry() === $this) {
                $organizer->setCountry(null);
            }
        }

        return $this;
    }

}
