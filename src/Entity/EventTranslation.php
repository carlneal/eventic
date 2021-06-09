<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventTranslationRepository")
 * @ORM\Table(name="eventic_event_translation")
 */
class EventTranslation {

    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min = 10, max = 100)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank
     * @Assert\Length(min = 10)
     */
    protected $description;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(length=150, unique=true)
     */
    protected $slug;

    public function getName() {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;

        return $this;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

}
