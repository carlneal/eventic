<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlogPostCategoryRepository")
 * @ORM\Table(name="eventic_blog_post_category")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class BlogPostCategory {

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
     * @ORM\OneToMany(targetEntity="BlogPost", mappedBy="category")
     */
    private $blogposts;

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
        $this->blogposts = new ArrayCollection();
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
     * @return Collection|BlogPost[]
     */
    public function getBlogposts(): Collection {
        return $this->blogposts;
    }

    public function addBlogpost(BlogPost $blogpost) {
        if (!$this->blogposts->contains($blogpost)) {
            $this->blogposts[] = $blogpost;
            $blogpost->setCategory($this);
        }

        return $this;
    }

    public function removeBlogpost(BlogPost $blogpost) {
        if ($this->blogposts->contains($blogpost)) {
            $this->blogposts->removeElement($blogpost);
// set the owning side to null (unless already changed)
            if ($blogpost->getCategory() === $this) {
                $blogpost->setCategory(null);
            }
        }

        return $this;
    }

}
