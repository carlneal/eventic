<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HelpCenterArticleTranslationRepository")
 * @ORM\Table(name="eventic_help_center_article_translation")
 */
class HelpCenterArticleTranslation {

    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="string", length=80, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min = 1, max = 80)
     */
    protected $title;

    /**
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @ORM\Column(length=100, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(min = 10)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\Length(max = 150)
     */
    protected $tags;

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    public function getTags() {
        return $this->tags;
    }

    public function setTags($tags) {
        $this->tags = $tags;

        return $this;
    }

}
