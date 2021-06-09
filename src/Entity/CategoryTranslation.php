<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryTranslationRepository")
 * @ORM\Table(name="eventic_category_translation")
 */
class CategoryTranslation {

    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min = 1, max = 50)
     */
    protected $name;

    /**
     * @Gedmo\Slug(fields={"name"}, updatable=true)
     * @ORM\Column(length=80, unique=true)
     */
    protected $slug;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

}
