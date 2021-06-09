<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SettingsRepository")
 * @ORM\Table(name="eventic_settings")
 */
class Settings {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $value;

    public function getId() {
        return $this->id;
    }

    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = $key;

        return $this;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

}
