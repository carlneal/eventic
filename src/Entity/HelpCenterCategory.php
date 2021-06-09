<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HelpCenterCategoryRepository")
 * @ORM\Table(name="eventic_help_center_category")
 * @Assert\Callback({"App\Validation\Validator", "validate"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class HelpCenterCategory {

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
     * @ORM\OneToMany(targetEntity="HelpCenterCategory", mappedBy="parent", cascade={"remove"})
     */
    private $subcategories;

    /**
     * @ORM\ManyToOne(targetEntity="HelpCenterCategory", inversedBy="subcategories")
     * @ORM\JoinColumn(nullable=true)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="HelpCenterArticle", mappedBy="category")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $icon;

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
        $this->articles = new ArrayCollection();
        $this->subcategories = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function __call($method, $arguments) {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function getName() {
        return $this->translate()->getName();
    }

    public function displayIcon() {
        return '<i class="' . $this->icon . '"></i>';
    }

    public function getUpdatedAt() {
        return $this->updatedAt == $this->createdAt ? null : $this->updatedAt;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function setIcon($icon) {
        $this->icon = $icon;

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

    /**
     * @return Collection|HelpCenterArticle[]
     */
    public function getArticles() {
        return $this->articles;
    }

    public function addArticle($article) {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle($article) {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
// set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }

    public function getHidden() {
        return $this->hidden;
    }

    public function setHidden($hidden) {
        $this->hidden = $hidden;

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
     * @return Collection|HelpCenterCategory[]
     */
    public function getSubcategories() {
        return $this->subcategories;
    }

    public function addSubcategory($subcategory) {
        if (!$this->subcategories->contains($subcategory)) {
            $this->subcategories[] = $subcategory;
            $subcategory->setParent($this);
        }

        return $this;
    }

    public function removeSubcategory($subcategory) {
        if ($this->subcategories->contains($subcategory)) {
            $this->subcategories->removeElement($subcategory);
// set the owning side to null (unless already changed)
            if ($subcategory->getParent() === $this) {
                $subcategory->setParent(null);
            }
        }

        return $this;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;

        return $this;
    }

}
