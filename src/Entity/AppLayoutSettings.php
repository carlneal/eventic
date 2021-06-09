<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppLayoutSettingsRepository")
 * @ORM\Table(name="eventic_app_layout_setting")
 * @Vich\Uploadable
 */
class AppLayoutSettings {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="app_layout", fileNameProperty="logoName", size="logoSize", mimeType="logoMimeType", originalName="logoOriginalName", dimensions="logoDimensions")
     * @Assert\File(
     *     maxSize = "5M",
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
     * @Vich\UploadableField(mapping="app_layout", fileNameProperty="faviconName", size="faviconSize", mimeType="faviconMimeType", originalName="faviconOriginalName", dimensions="faviconDimensions")
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png", "image/x-icon"},
     *     mimeTypesMessage = "The file should be an image"
     *     )
     * @var File
     */
    private $faviconFile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $faviconName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $faviconSize;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $faviconMimeType;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $faviconOriginalName;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $faviconDimensions;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="app_layout", fileNameProperty="ogImageName", size="ogImageSize", mimeType="ogImageMimeType", originalName="ogImageOriginalName", dimensions="ogImageDimensions")
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/jpg", "image/gif", "image/png", "image/x-icon"},
     *     mimeTypesMessage = "The file should be an image"
     *     )
     * @var File
     */
    private $ogImageFile;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ogImageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $ogImageSize;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ogImageMimeType;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $ogImageOriginalName;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $ogImageDimensions;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct() {

    }

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
        return 'uploads/layout/' . $this->logoName;
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
    public function setFaviconFile(File $faviconFile = null) {
        $this->faviconFile = $faviconFile;

        if (null !== $faviconFile) {
// It is required that at least one field changes if you are using doctrine
// otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getFaviconFile() {
        return $this->faviconFile;
    }

    public function getFaviconPath() {
        return 'uploads/layout/' . $this->faviconName;
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
    public function setOgImageFile(File $ogImageFile = null) {
        $this->ogImageFile = $ogImageFile;

        if (null !== $ogImageFile) {
// It is required that at least one field changes if you are using doctrine
// otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getOgImageFile() {
        return $this->ogImageFile;
    }

    public function getOgImagePath() {
        return 'uploads/layout/' . $this->ogImageName;
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

    public function getFaviconName() {
        return $this->faviconName;
    }

    public function setFaviconName($faviconName) {
        $this->faviconName = $faviconName;

        return $this;
    }

    public function getFaviconSize() {
        return $this->faviconSize;
    }

    public function setFaviconSize($faviconSize) {
        $this->faviconSize = $faviconSize;

        return $this;
    }

    public function getFaviconMimeType() {
        return $this->faviconMimeType;
    }

    public function setFaviconMimeType($faviconMimeType) {
        $this->faviconMimeType = $faviconMimeType;

        return $this;
    }

    public function getFaviconOriginalName() {
        return $this->faviconOriginalName;
    }

    public function setFaviconOriginalName($faviconOriginalName) {
        $this->faviconOriginalName = $faviconOriginalName;

        return $this;
    }

    public function getFaviconDimensions() {
        return $this->faviconDimensions;
    }

    public function setFaviconDimensions($faviconDimensions) {
        $this->faviconDimensions = $faviconDimensions;

        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getOgImageName() {
        return $this->ogImageName;
    }

    public function setOgImageName($ogImageName) {
        $this->ogImageName = $ogImageName;

        return $this;
    }

    public function getOgImageSize() {
        return $this->ogImageSize;
    }

    public function setOgImageSize($ogImageSize) {
        $this->ogImageSize = $ogImageSize;

        return $this;
    }

    public function getOgImageMimeType() {
        return $this->ogImageMimeType;
    }

    public function setOgImageMimeType($ogImageMimeType) {
        $this->ogImageMimeType = $ogImageMimeType;

        return $this;
    }

    public function getOgImageOriginalName() {
        return $this->ogImageOriginalName;
    }

    public function setOgImageOriginalName($ogImageOriginalName) {
        $this->ogImageOriginalName = $ogImageOriginalName;

        return $this;
    }

    public function getOgImageDimensions() {
        return $this->ogImageDimensions;
    }

    public function setOgImageDimensions($ogImageDimensions) {
        $this->ogImageDimensions = $ogImageDimensions;

        return $this;
    }

}
