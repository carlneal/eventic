<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ThreadRepository")
 * @ORM\Table(name="eventic_thread")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Thread extends BaseThread {

    /**
     * @var string $id
     *
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    public function getId() {
        return $this->id;
    }

}
