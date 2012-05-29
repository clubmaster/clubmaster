<?php

namespace Club\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\MatchBundle\Entity\MatchComment
 *
 * @ORM\Table(name="club_match_match_comment")
 * @ORM\Entity(repositoryClass="Club\MatchBundle\Entity\MatchCommentRepository")
 * @ORM\HasLifeCycleCallbacks()
 */
class MatchComment
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $comment
     *
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="Match")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    protected $match;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set comment
     *
     * @param text $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get comment
     *
     * @return text
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set match
     *
     * @param Club\MatchBundle\Entity\Match $match
     */
    public function setMatch(\Club\MatchBundle\Entity\Match $match)
    {
        $this->match = $match;
    }

    /**
     * Get match
     *
     * @return Club\MatchBundle\Entity\Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     */
    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Club\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
