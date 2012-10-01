<?php

namespace Club\RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Club\RankingBundle\Entity\MatchRepository")
 * @ORM\Table(name="club_ranking_match")
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Match
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var string $processed
     */
    protected $processed;

    /**
     * @ORM\ManyToOne(targetEntity="Ranking")
     */
    protected $ranking;

    /**
     * @ORM\ManyToOne(targetEntity="Club\MatchBundle\Entity\Match")
     */
    protected $match;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var date $created_at
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var date $updated_at
     */
    protected $updated_at;

    /**
     * Get id
     *
     * @return integer $id
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
     * Set processed
     *
     * @param boolean $processed
     * @return Match
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;

        return $this;
    }

    /**
     * Get processed
     *
     * @return boolean
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * Set ranking
     *
     * @param Club\RankingBundle\Entity\Ranking $ranking
     * @return Match
     */
    public function setRanking(\Club\RankingBundle\Entity\Ranking $ranking = null)
    {
        $this->ranking = $ranking;

        return $this;
    }

    /**
     * Get ranking
     *
     * @return Club\RankingBundle\Entity\Ranking
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * Set match
     *
     * @param Club\MatchBundle\Entity\Match $match
     * @return Match
     */
    public function setMatch(\Club\MatchBundle\Entity\Match $match = null)
    {
        $this->match = $match;

        return $this;
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
}
