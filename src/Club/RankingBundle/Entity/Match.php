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
     * @var string $display_result
     *
     * @ORM\Column(type="string")
     */
    private $display_result;

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
     * @ORM\ManyToOne(targetEntity="Club\RankingBundle\Entity\MatchTeam")
     */
    protected $winner;

    /**
     * @ORM\ManyToOne(targetEntity="Club\RankingBundle\Entity\Game")
     */
    protected $game;

    /**
     * @var Club\RankingBundle\Entity\MatchTeam
     *
     * @ORM\OneToMany(targetEntity="MatchTeam", mappedBy="match", cascade={"persist"})
     */
    protected $match_teams;

    /**
     * @var Club\RankingBundle\Entity\MatchComment
     *
     * @ORM\OneToMany(targetEntity="MatchComment", mappedBy="match")
     */
    protected $match_comments;


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
     * Set display_result
     *
     * @param string $displayResult
     */
    public function setDisplayResult($displayResult)
    {
        $this->display_result = $displayResult;
    }

    /**
     * Get display_result
     *
     * @return string
     */
    public function getDisplayResult()
    {
        return $this->display_result;
    }

    public function getTeamOne()
    {
      $teams = $this->getMatchTeams();

      return ($teams[0]->getId() > $teams[1]->getId()) ? $teams[1] : $teams[0];
    }

    public function getTeamTwo()
    {
      $teams = $this->getMatchTeams();

      return ($teams[0]->getId() > $teams[1]->getId()) ? $teams[0] : $teams[1];
    }

    /**
     * Set winner
     *
     * @param Club\RankingBundle\Entity\MatchTeam $winner
     */
    public function setWinner(\Club\RankingBundle\Entity\MatchTeam $winner)
    {
        $this->winner = $winner;
    }

    /**
     * Get winner
     *
     * @return Club\RankingBundle\Entity\MatchTeam
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Add match_comments
     *
     * @param Club\RankingBundle\Entity\MatchComment $matchComments
     */
    public function addMatchComment(\Club\RankingBundle\Entity\MatchComment $matchComments)
    {
        $this->match_comments[] = $matchComments;
    }

    /**
     * Get match_comments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMatchComments()
    {
        return $this->match_comments;
    }
}