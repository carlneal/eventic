<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PointOfSaleRepository")
 * @ORM\Table(name="eventic_pointofsale")
 */
class PointOfSale {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank(groups={"create", "update"})
     * @Assert\Length(min = 2, max = 25, groups={"create", "update"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Organizer", inversedBy="pointofsales")
     */
    private $organizer;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="EventDate", mappedBy="pointofsales")
     */
    private $eventdates;

    public function __construct() {
        $this->eventdates = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function getOrganizer() {
        return $this->organizer;
    }

    public function setOrganizer($organizer) {
        $this->organizer = $organizer;

        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|EventDate[]
     */
    public function getEventdates() {
        return $this->eventdates;
    }

    public function addEventdate($eventdate) {
        if (!$this->eventdates->contains($eventdate)) {
            $this->eventdates[] = $eventdate;
            $eventdate->addPointofsale($this);
        }

        return $this;
    }

    public function removeEventdate($eventdate) {
        if ($this->eventdates->contains($eventdate)) {
            $this->eventdates->removeElement($eventdate);
            $eventdate->removePointofsale($this);
        }

        return $this;
    }

}
