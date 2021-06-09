<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HomepageHeroSettingsTranslationRepository")
 * @ORM\Table(name="eventic_homepage_hero_setting_translation")
 */
class HomepageHeroSettingsTranslation {

    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    protected $paragraph;

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    public function getParagraph() {
        return $this->paragraph;
    }

    public function setParagraph($paragraph) {
        $this->paragraph = $paragraph;

        return $this;
    }

}
