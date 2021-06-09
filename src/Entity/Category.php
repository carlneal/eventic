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
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="eventic_category")
 * @Assert\Callback({"App\Validation\Validator", "validate"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @Vich\Uploadable
 */
class Category {

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
     * @ORM\OneToMany(targetEntity="Event", mappedBy="category")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity="Organizer", mappedBy="categories")
     */
    private $organizers;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(min = 1, max = 50)
     */
    private $icon;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="category_image", fileNameProperty="imageName", size="imageSize", mimeType="imageMimeType", originalName="imageOriginalName", dimensions="imageDimensions")
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png"},
     *     mimeTypesMessage = "The file should be an image"
     *     )
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
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $hidden = false;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotNull
     */
    private $featured = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $featuredorder;

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
        $this->organizers = new ArrayCollection();
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

    public function getIcon() {
        return $this->icon;
    }

    public function setIcon(string $icon) {
        $this->icon = $icon;

        return $this;
    }

    public function getImageName() {
        return $this->imageName;
    }

    public function setImageName($imageName) {
        $this->imageName = $imageName;

        return $this;
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

    public function displayIcon() {
        return '<i class="' . $this->icon . '"></i>';
    }

    public function getImagePath() {
        return 'uploads/categories/' . $this->imageName;
    }

    public function getImagePlaceholder($size = "default") {
        if ($size == "small") {
            return "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAABGCAMAAABG8BK2AAAA/1BMVEUAAAD2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhH2dhFzESFhAAAAVHRSTlMAAQIDBQYICQsNDhAREhQVGBobISQmLC0wMTQ1ODlAQkNLT1xdY2ZpbXR1d3mDhoiLjpGSlZeYnaCjpaaqtLq8yMrMzs/R1d7k5ujp6+3z9ff5+/1JGcHEAAABMUlEQVRYw+3W2U4CQRCF4dMzAqO47zvuu6iAorjgDjpuQL3/s3jjBTCkulLpRBP7f4AvmaqeTgM+n8/3Gw2un5R/Km6NKRGzRx2VAhWTp66uNMoUJcopmLMk86BgXpMMKabTQ6EoaM9oma7i3YwLhuhjwglDXwNOGDp3w1Dohsm6YYb/PVOci0Rnn2Oa2ykV0clU+9VIG1MyANC3tHNaZjqa4ZlLAyB9aJ91xDF3IYCFhl2JDcO8ZACsSBY/yXxUYwQ9L/dkq9yIpwFkPwXKPrepNQCpmkCpcAs/AGBuBMp9yDAXAFAQKDFzs9NtAGBToDRHmVNcTwNYlCxpnvsZhgCMtwTKBixFbwLl2KaEjwLl2noN5QVKxf46sA/mfdmKALlnjmg9FWZ1zzifz+f7c30DdESL++xXlRkAAAAASUVORK5CYII=";
        } else {
            return "data:image/png;base64,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";
        }
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents() {
        return $this->events;
    }

    public function addEvent(Event $event) {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setCategory($this);
        }

        return $this;
    }

    public function removeEvent(Event $event) {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
// set the owning side to null (unless already changed)
            if ($event->getCategory() === $this) {
                $event->setCategory(null);
            }
        }

        return $this;
    }

    public function getDeletedAt() {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
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

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

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

    public function getFeatured() {
        return $this->featured;
    }

    public function setFeatured($featured) {
        $this->featured = $featured;

        return $this;
    }

    /**
     * @return Collection|Organizer[]
     */
    public function getOrganizers() {
        return $this->organizers;
    }

    public function addOrganizer(Organizer $organizer) {
        if (!$this->organizers->contains($organizer)) {
            $this->organizers[] = $organizer;
            $organizer->addCategory($this);
        }

        return $this;
    }

    public function removeOrganizer(Organizer $organizer) {
        if ($this->organizers->contains($organizer)) {
            $this->organizers->removeElement($organizer);
            $organizer->removeCategory($this);
        }

        return $this;
    }

    public function getFeaturedorder() {
        return $this->featuredorder;
    }

    public function setFeaturedorder($featuredorder) {
        $this->featuredorder = $featuredorder;

        return $this;
    }

}
