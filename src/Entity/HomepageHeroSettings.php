<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use ORMBehaviors\Translatable\Translatable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HomepageHeroSettingsRepository")
 * @ORM\Table(name="eventic_homepage_hero_setting")
 * @Vich\Uploadable
 */
class HomepageHeroSettings {

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
     * @ORM\Column(type="string", length=15, nullable=false)
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="isonhomepageslider", cascade={"persist"})
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="isorganizeronhomepageslider")
     */
    private $organizers;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="homepage_hero_custom_background", fileNameProperty="customBackgroundName", size="customBackgroundSize", mimeType="customBackgroundMimeType", originalName="customBackgroundOriginalName", dimensions="customBackgroundDimensions")
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png"},
     *     mimeTypesMessage = "The file should be an image"
     *     )
     * @var File
     */
    private $customBackgroundFile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $customBackgroundName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $customBackgroundSize;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $customBackgroundMimeType;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $customBackgroundOriginalName;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $customBackgroundDimensions;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $show_search_box;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct() {
        $this->events = new ArrayCollection();
        $this->organizers = new ArrayCollection();
    }

    public function clearEvents() {
        $this->events->clear();
    }

    public function getId() {
        return $this->id;
    }

    public function __call($method, $arguments) {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
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
    public function setCustomBackgroundFile(File $customBackgroundFile = null) {
        $this->customBackgroundFile = $customBackgroundFile;

        if (null !== $customBackgroundFile) {
// It is required that at least one field changes if you are using doctrine
// otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getCustomBackgroundFile() {
        return $this->customBackgroundFile;
    }

    public function getCustomBackgroundPath() {
        return 'uploads/homepage/hero/' . $this->customBackgroundName;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    public function getCustomBackgroundName() {
        return $this->customBackgroundName;
    }

    public function setCustomBackgroundName($customBackgroundName) {
        $this->customBackgroundName = $customBackgroundName;

        return $this;
    }

    public function getCustomBackgroundSize() {
        return $this->customBackgroundSize;
    }

    public function setCustomBackgroundSize($customBackgroundSize) {
        $this->customBackgroundSize = $customBackgroundSize;

        return $this;
    }

    public function getCustomBackgroundMimeType() {
        return $this->customBackgroundMimeType;
    }

    public function setCustomBackgroundMimeType($customBackgroundMimeType) {
        $this->customBackgroundMimeType = $customBackgroundMimeType;

        return $this;
    }

    public function getCustomBackgroundOriginalName() {
        return $this->customBackgroundOriginalName;
    }

    public function setCustomBackgroundOriginalName($customBackgroundOriginalName) {
        $this->customBackgroundOriginalName = $customBackgroundOriginalName;

        return $this;
    }

    public function getCustomBackgroundDimensions() {
        return $this->customBackgroundDimensions;
    }

    public function setCustomBackgroundDimensions($customBackgroundDimensions) {
        $this->customBackgroundDimensions = $customBackgroundDimensions;

        return $this;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

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
            $event->setIsonhomepageslider($this);
        }

        return $this;
    }

    public function removeEvent($event) {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
// set the owning side to null (unless already changed)
            if ($event->getIsonhomepageslider() === $this) {
                $event->setIsonhomepageslider(null);
            }
        }

        return $this;
    }

    public function getShowSearchBox() {
        return $this->show_search_box;
    }

    public function setShowSearchBox($show_search_box) {
        $this->show_search_box = $show_search_box;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getOrganizers() {
        return $this->organizers;
    }

    public function addOrganizer($organizer) {
        if (!$this->organizers->contains($organizer)) {
            $this->organizers[] = $organizer;
            $organizer->setIsorganizeronhomepageslider($this);
        }

        return $this;
    }

    public function removeOrganizer($organizer) {
        if ($this->organizers->contains($organizer)) {
            $this->organizers->removeElement($organizer);
// set the owning side to null (unless already changed)
            if ($organizer->getIsorganizeronhomepageslider() === $this) {
                $organizer->setIsorganizeronhomepageslider(null);
            }
        }

        return $this;
    }

}
