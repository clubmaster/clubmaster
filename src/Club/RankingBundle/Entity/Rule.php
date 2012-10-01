<?php

namespace Club\RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\RankingBundle\Entity\Rule
 *
 * @ORM\Table(name="club_ranking_rule")
 * @ORM\Entity(repositoryClass="Club\RankingBundle\Entity\RuleRepository")
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
     * @var integer $point_lost
     *
     * @ORM\Column(type="integer")
     */
    private $point_lost;

    /**
     * @var integer $same_player
     *
     * @ORM\Column(type="integer")
     */
    private $same_player;

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
     * Set point_lost
     *
     * @param integer $pointLost
     */
    public function setPointLost($pointLost)
    {
        $this->point_lost = $pointLost;
    }

    /**
     * Get point_lost
     *
     * @return integer
     */
    public function getPointLost()
    {
        return $this->point_lost;
    }

    /**
     * Set same_player
     *
     * @param integer $samePlayer
     */
    public function setSamePlayer($samePlayer)
    {
        $this->same_player = $samePlayer;
    }

    /**
     * Get same_player
     *
     * @return integer
     */
    public function getSamePlayer()
    {
        return $this->same_player;
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