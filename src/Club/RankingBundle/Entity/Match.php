<?php

namespace Club\RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\RankingBundle\Entity\Match
 *
 * @ORM\Table(name="club_ranking_match")
 * @ORM\Entity(repositoryClass="Club\RankingBundle\Entity\MatchRepository")
 * @ORM\HasLifeCycleCallbacks()
 */
class Match
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
     * @ORM\ManyToOne(targetEntity="Club\RankingBundle\Entity\Game")
     */
    protected $game;

    /**
     * @var Club\RankingBundle\Entity\MatchTeam
     *
     * @ORM\OneToMany(targetEntity="MatchTeam", mappedBy="match")
     */
    protected $match_teams;

    /**
     * @var Club\RankingBundle\Entity\MatchSet
     *
     * @ORM\OneToMany(targetEntity="MatchSet", mappedBy="match")
     */
    protected $match_sets;


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
     * Set game
     *
     * @param Club\RankingBundle\Entity\Game $game
     */
    public function setGame(\Club\RankingBundle\Entity\Game $game)
    {
        $this->game = $game;
    }

    /**
     * Get game
     *
     * @return Club\RankingBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }
    public function __construct()
    {
        $this->match_teams = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add match_teams
     *
     * @param Club\RankingBundle\Entity\MatchTeam $matchTeams
     */
    public function addMatchTeam(\Club\RankingBundle\Entity\MatchTeam $matchTeams)
    {
        $this->match_teams[] = $matchTeams;
    }

    /**
     * Get match_teams
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMatchTeams()
    {
        return $this->match_teams;
    }

    /**
     * Add match_sets
     *
     * @param Club\RankingBundle\Entity\MatchSet $matchSets
     */
    public function addMatchSet(\Club\RankingBundle\Entity\MatchSet $matchSets)
    {
        $this->match_sets[] = $matchSets;
    }

    /**
     * Get match_sets
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMatchSets()
    {
        return $this->match_sets;
    }
}
