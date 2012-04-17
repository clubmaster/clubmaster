<?php

namespace Club\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\MatchBundle\Entity\LeagueTable
 *
 * @ORM\Table(name="club_match_league_table")
 * @ORM\Entity(repositoryClass="Club\MatchBundle\Entity\LeagueTableRepository")
 * @ORM\HasLifeCycleCallbacks()
 *
 */
class LeagueTable
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
     * @var integer $played
     *
     * @ORM\Column(type="integer")
     */
    private $played;

    /**
     * @var integer $win
     *
     * @ORM\Column(type="integer")
     */
    private $win;

    /**
     * @var integer $loss
     *
     * @ORM\Column(type="integer")
     */
    private $loss;

    /**
     * @var integer $point
     *
     * @ORM\Column(type="integer")
     */
    private $point;

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
     * @ORM\ManyToOne(targetEntity="League")
     * @ORM\JoinColumn(onDelete="cascade")
     *
     * @var Club\MatchBundle\Entity\League
     */
    protected $league;

    /**
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(onDelete="cascade")
     *
     * @var Club\MatchBundle\Entity\Team
     */
    protected $team;


    public function __construct()
    {
      $this->win = 0;
      $this->loss = 0;
      $this->point = 0;
      $this->played = 0;
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
     * Set team
     *
     * @param Club\MatchBundle\Entity\Team $team
     */
    public function setTeam(\Club\MatchBundle\Entity\Team $team)
    {
        $this->team = $team;
    }

    /**
     * Get team
     *
     * @return Club\MatchBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
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
     * Set played
     *
     * @param integer $played
     */
    public function setPlayed($played)
    {
        $this->played = $played;
    }

    /**
     * Get played
     *
     * @return integer
     */
    public function getPlayed()
    {
        return $this->played;
    }

    /**
     * Set win
     *
     * @param integer $win
     */
    public function setWin($win)
    {
        $this->win = $win;
    }

    /**
     * Get win
     *
     * @return integer
     */
    public function getWin()
    {
        return $this->win;
    }

    /**
     * Set loss
     *
     * @param integer $loss
     */
    public function setLoss($loss)
    {
        $this->loss = $loss;
    }

    /**
     * Get loss
     *
     * @return integer
     */
    public function getLoss()
    {
        return $this->loss;
    }

    /**
     * Set point
     *
     * @param integer $point
     */
    public function setPoint($point)
    {
        $this->point = $point;
    }

    /**
     * Get point
     *
     * @return integer
     */
    public function getPoint()
    {
        return $this->point;
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
     * Set league
     *
     * @param Club\MatchBundle\Entity\League $league
     */
    public function setLeague(\Club\MatchBundle\Entity\League $league)
    {
        $this->league = $league;
    }

    /**
     * Get league
     *
     * @return Club\MatchBundle\Entity\League
     */
    public function getLeague()
    {
        return $this->league;
    }
}
