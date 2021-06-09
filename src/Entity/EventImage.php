<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventImageRepository")
 * @ORM\Table(name="eventic_event_image")
 * @Vich\Uploadable
 */
class EventImage {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="images")
     */
    private $event;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="event_image", fileNameProperty="imageName", size="imageSize", mimeType="imageMimeType", originalName="imageOriginalName", dimensions="imageDimensions")
     * @Assert\NotNull(groups={"create"})
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png"},
     *     mimeTypesMessage = "The file should be an image",
     *      groups={"create"}
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
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @var \DateTime $updatedAt
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getId() {
        return $this->id;
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

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;

        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getEvent() {
        return $this->event;
    }

    public function setEvent($event) {
        $this->event = $event;

        return $this;
    }

}
