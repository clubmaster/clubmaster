<?php

namespace Club\RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\RankingBundle\Entity\MatchTeam
 *
 * @ORM\Table(name="club_ranking_match_team")
 * @ORM\Entity(repositoryClass="Club\RankingBundle\Entity\MatchTeamRepository")
 */
class MatchTeam
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
     * @ORM\ManyToOne(targetEntity="Match")
     * @ORM\JoinColumn(name="match_id", onDelete="cascade")
     *
     * @var Club\RankingBundle\Entity\Match
     */
    protected $match;

    /**
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(onDelete="cascade")
     *
     * @var Club\RankingBundle\Entity\Team
     */
    protected $team;

    /**
     * @var Club\RankingBundle\Entity\MatchTeamSet
     *
     * @ORM\OneToMany(targetEntity="MatchTeamSet", mappedBy="match_team", cascade={"persist"})
     */
    protected $match_team_set;


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
     * Set match
     *
     * @param Club\RankingBundle\Entity\Match $match
     */
    public function setMatch(\Club\RankingBundle\Entity\Match $match)
    {
        $this->match = $match;
    }

    /**
     * Get match
     *
     * @return Club\RankingBundle\Entity\Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Add match_team_set
     *
     * @param Club\RankingBundle\Entity\MatchTeamSet $matchTeamSet
     */
    public function addMatchTeamSet(\Club\RankingBundle\Entity\MatchTeamSet $matchTeamSet)
    {
        $this->match_team_set[] = $matchTeamSet;
    }

    /**
     * Get match_team_set
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMatchTeamSet()
    {
        return $this->match_team_set;
    }
    public function __construct()
    {
        $this->match_team_set = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set team
     *
     * @param Club\RankingBundle\Entity\Team $team
     */
    public function setTeam(\Club\RankingBundle\Entity\Team $team)
    {
        $this->team = $team;
    }

    /**
     * Get team
     *
     * @return Club\RankingBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }
}