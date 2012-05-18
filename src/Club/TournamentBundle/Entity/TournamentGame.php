<?php

namespace Club\TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\TournamentBundle\Entity\TournamentGame
 *
 * @ORM\Table(name="club_tournament_tournament_game")
 * @ORM\Entity(repositoryClass="Club\TournamentBundle\Entity\TournamentGameRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TournamentGame
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $round
     *
     * @ORM\Column(name="round", type="integer")
     */
    private $round;

    /**
     * @var integer $game
     *
     * @ORM\Column(name="game", type="integer")
     */
    private $game;

    /**
     * @var string $result
     *
     * @ORM\Column(name="result", type="string", length=255, nullable=true)
     */
    private $result;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="Tournament")
     */
    private $tournament;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    private $team_one;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    private $team_two;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    private $winner;


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
     * Set round
     *
     * @param integer $round
     */
    public function setRound($round)
    {
        $this->round = $round;
    }

    /**
     * Get round
     *
     * @return integer
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Set game
     *
     * @param integer $game
     */
    public function setGame($game)
    {
        $this->game = $game;
    }

    /**
     * Get game
     *
     * @return integer
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set result
     *
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * Get result
     *
     * @return string
     */
    public function getResult()
    {
        return $this->result;
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
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set tournament
     *
     * @param Club\TournamentBundle\Entity\Tournament $tournament
     */
    public function setTournament(\Club\TournamentBundle\Entity\Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * Get tournament
     *
     * @return Club\TournamentBundle\Entity\Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * Set winner
     *
     * @param Club\UserBundle\Entity\User $winner
     */
    public function setWinner(\Club\UserBundle\Entity\User $winner)
    {
        $this->winner = $winner;
    }

    /**
     * Get winner
     *
     * @return Club\UserBundle\Entity\User
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\preUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set team_one
     *
     * @param Club\UserBundle\Entity\User $teamOne
     */
    public function setTeamOne(\Club\UserBundle\Entity\User $teamOne)
    {
        $this->team_one = $teamOne;
    }

    /**
     * Get team_one
     *
     * @return Club\UserBundle\Entity\User
     */
    public function getTeamOne()
    {
        return $this->team_one;
    }

    /**
     * Set team_two
     *
     * @param Club\UserBundle\Entity\User $teamTwo
     */
    public function setTeamTwo(\Club\UserBundle\Entity\User $teamTwo)
    {
        $this->team_two = $teamTwo;
    }

    /**
     * Get team_two
     *
     * @return Club\UserBundle\Entity\User
     */
    public function getTeamTwo()
    {
        return $this->team_two;
    }
}