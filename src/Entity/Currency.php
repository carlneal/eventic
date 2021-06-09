<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyRepository")
 * @ORM\Table(name="eventic_currency")
 * @UniqueEntity("ccy")
 */
class Currency {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min = 3, max = 3)
     * @ORM\Column(type="string", length=3, unique=true)
     */
    private $ccy;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min = 1, max = 50)
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $symbol;

    public function getId() {
        return $this->id;
    }

    public function getCcy() {
        return $this->ccy;
    }

    public function setCcy($ccy) {
        $this->ccy = $ccy;

        return $this;
    }

    public function getSymbol() {
        return $this->symbol;
    }

    public function setSymbol($symbol) {
        $this->symbol = $symbol;

        return $this;
    }

}
