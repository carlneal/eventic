<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Vote as BaseVote;
use FOS\CommentBundle\Model\SignedVoteInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\CommentBundle\Model\VotableCommentInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 * @ORM\Table(name="eventic_vote")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Vote extends BaseVote implements SignedVoteInterface {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * Comment of this vote
     *
     * @var Comment
     * @ORM\ManyToOne(targetEntity="Comment")
     */
    protected $comment;

    /**
     * Author of the vote
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @var User
     */
    protected $voter;

    public function getId() {
        return $this->id;
    }

    /**
     * Sets the owner of the vote
     *
     * @param UserInterface $voter
     */
    public function setVoter(UserInterface $voter) {
        $this->voter = $voter;
    }

    /**
     * Gets the owner of the vote
     *
     * @return UserInterface
     */
    public function getVoter() {
        return $this->voter;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment(VotableCommentInterface $comment) {
        $this->comment = $comment;

        return $this;
    }

}
