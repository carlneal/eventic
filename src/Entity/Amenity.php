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
 * @ORM\Entity(repositoryClass="App\Repository\AmenityRepository")
 * @ORM\Table(name="eventic_amenity")
 * @Assert\Callback({"App\Validation\Validator", "validate"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Amenity {

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
     * @ORM\ManyToMany(targetEntity="Venue", mappedBy="amenities")
     */
    private $venues;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(min = 1, max = 50)
     */
    private $icon;

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
        $this->venues = new ArrayCollection();
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

    public function displayIcon() {
        return '<i class="' . $this->icon . '"></i>';
    }

    public function getUpdatedAt() {
        return $this->updatedAt == $this->createdAt ? null : $this->updatedAt;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function setIcon(string $icon) {
        $this->icon = $icon;

        return $this;
    }

    public function getHidden() {
        return $this->hidden;
    }

    public function setHidden(bool $hidden) {
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

    /**
     * @return Collection|Venue[]
     */
    public function getVenues(): Collection {
        return $this->venues;
    }

    public function addVenue(Venue $venue) {
        if (!$this->venues->contains($venue)) {
            $this->venues[] = $venue;
            $venue->addAmenity($this);
        }

        return $this;
    }

    public function removeVenue(Venue $venue) {
        if ($this->venues->contains($venue)) {
            $this->venues->removeElement($venue);
            $venue->removeAmenity($this);
        }

        return $this;
    }

}
