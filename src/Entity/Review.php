<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="eventic_review")
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Review {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="reviews")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reviews")
     */
    private $user;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $rating;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(min=10, max=100)
     * @Assert\NotBlank
     */
    private $headline;

    /**
     * @Gedmo\Slug(fields={"headline"}, updatable=true)
     * @ORM\Column(length=120, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\Length(min=25, max=500)
     * @Assert\NotBlank
     */
    private $details;

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
    private $visible = true;

    public function getId() {
        return $this->id;
    }

    public function __construct() {
        $this->visible = true;
    }

    public function getRatingPercentage() {
        return ($this->rating / 5) * 100;
    }

    public function getRating() {
        return $this->rating;
    }

    public function setRating($rating) {
        $this->rating = $rating;

        return $this;
    }

    public function getHeadline() {
        return $this->headline;
    }

    public function setHeadline($headline) {
        $this->headline = $headline;

        return $this;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    public function getDetails() {
        return $this->details;
    }

    public function setDetails($details) {
        $this->details = $details;

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

    public function getVisible() {
        return $this->visible;
    }

    public function setVisible($visible) {
        $this->visible = $visible;

        return $this;
    }

    public function getEvent() {
        return $this->event;
    }

    public function setEvent($event) {
        $this->event = $event;

        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

}
