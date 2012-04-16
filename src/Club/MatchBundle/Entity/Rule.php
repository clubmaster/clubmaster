<?php

namespace Club\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\MatchBundle\Entity\Rule
 *
 * @ORM\Table(name="club_match_rule")
 * @ORM\Entity(repositoryClass="Club\MatchBundle\Entity\RuleRepository")
 * @ORM\HasLifeCycleCallbacks()
 */
class Rule
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
     * @var string $name
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var integer $point_won
     *
     * @ORM\Column(type="integer")
     */
    private $point_won;

    /**
     * @var integer $point_loss
     *
     * @ORM\Column(type="integer")
     */
    private $point_loss;

    /**
     * @var integer $match_same_player
     *
     * @ORM\Column(type="integer")
     */
    private $match_same_player;

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


    public function __toString()
    {
      return $this->getName();
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set point_won
     *
     * @param integer $pointWon
     */
    public function setPointWon($pointWon)
    {
        $this->point_won = $pointWon;
    }

    /**
     * Get point_won
     *
     * @return integer
     */
    public function getPointWon()
    {
        return $this->point_won;
    }

    /**
     * Set point_loss
     *
     * @param integer $pointLoss
     */
    public function setPointLoss($pointLoss)
    {
        $this->point_loss = $pointLoss;
    }

    /**
     * Get point_loss
     *
     * @return integer
     */
    public function getPointLoss()
    {
        return $this->point_loss;
    }

    /**
     * Set match_same_player
     *
     * @param integer $matchSamePlayer
     */
    public function setMatchSamePlayer($matchSamePlayer)
    {
        $this->match_same_player = $matchSamePlayer;
    }

    /**
     * Get match_same_player
     *
     * @return integer
     */
    public function getMatchSamePlayer()
    {
        return $this->match_same_player;
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
}