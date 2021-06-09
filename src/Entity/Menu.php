<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 * @ORM\Table(name="eventic_menu")
 * @Assert\Callback({"App\Validation\Validator", "validate"})
 */
class Menu {

    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="MenuElement", mappedBy="menu", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     * @Assert\Valid()
     */
    private $menuElements;

    /**
     * @Assert\Valid()
     */
    protected $translations;

    public function __construct() {
        $this->menuElements = new ArrayCollection();
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

    public function getHeader() {
        return $this->translate()->getHeader();
    }

    /**
     * @return Collection|MenuElement[]
     */
    public function getMenuElements(): Collection {
        return $this->menuElements;
    }

    public function addMenuElement(MenuElement $menuElement): self {
        if (!$this->menuElements->contains($menuElement)) {
            $this->menuElements[] = $menuElement;
            $menuElement->setMenu($this);
        }

        return $this;
    }

    public function removeMenuElement(MenuElement $menuElement): self {
        if ($this->menuElements->contains($menuElement)) {
            $this->menuElements->removeElement($menuElement);
// set the owning side to null (unless already changed)
            if ($menuElement->getMenu() === $this) {
                $menuElement->setMenu(null);
            }
        }

        return $this;
    }

}
