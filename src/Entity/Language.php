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
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 * @ORM\Table(name="eventic_language")
 * @Assert\Callback({"App\Validation\Validator", "validate"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Language {

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
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="languages")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="subtitles")
     */
    private $eventssubtitled;

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
        $this->eventssubtitled = new ArrayCollection();
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

    public function getUpdatedAt() {
        return $this->updatedAt == $this->createdAt ? null : $this->updatedAt;
    }

    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;

        return $this;
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

    /**
     * @return Collection|Event[]
     */
    public function getEvents() {
        return $this->events;
    }

    public function addEvent($event) {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addLanguage($this);
        }

        return $this;
    }

    public function removeEvent($event) {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeLanguage($this);
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEventssubtitled() {
        return $this->eventssubtitled;
    }

    public function addEventssubtitled($eventssubtitled) {
        if (!$this->eventssubtitled->contains($eventssubtitled)) {
            $this->eventssubtitled[] = $eventssubtitled;
            $eventssubtitled->addSubtitle($this);
        }

        return $this;
    }

    public function removeEventssubtitled($eventssubtitled) {
        if ($this->eventssubtitled->contains($eventssubtitled)) {
            $this->eventssubtitled->removeElement($eventssubtitled);
            $eventssubtitled->removeSubtitle($this);
        }

        return $this;
    }

}
