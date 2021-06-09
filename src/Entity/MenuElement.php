<?php

namespace App\Entity;

use App\Repository\MenuElementRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuElementRepository")
 * @ORM\Table(name="eventic_menu_element")
 * @Assert\Callback({"App\Validation\Validator", "validate"})
 */
class MenuElement {

    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Length(max = 50)
     */
    protected $icon;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    protected $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max = 255)
     */
    protected $customLink;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menuElements")
     */
    private $menu;

    /**
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @Assert\Valid()
     */
    protected $translations;

    public function getId() {
        return $this->id;
    }

    public function __call($method, $arguments) {
        return PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    public function getLabel() {
        return $this->translate()->getLabel();
    }

    public function getIcon() {
        return $this->icon;
    }

    public function setIcon($icon) {
        $this->icon = $icon;

        return $this;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function setMenu($menu) {
        $this->menu = $menu;

        return $this;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;

        return $this;
    }

    public function getCustomLink() {
        return $this->customLink;
    }

    public function setCustomLink($customLink) {
        $this->customLink = $customLink;

        return $this;
    }

}
