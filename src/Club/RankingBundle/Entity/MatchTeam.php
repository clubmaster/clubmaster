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
     * @var Club\RankingBundle\Entity\Match
     */
    protected $match;

    /**
     * @var Club\RankingBundle\Entity\MatchTeamUser
     *
     * @ORM\OneToMany(targetEntity="MatchTeamUser", mappedBy="match_team")
     */
    protected $match_team_users;


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
    public function __construct()
    {
        $this->match_team_users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add match_team_users
     *
     * @param Club\RankingBundle\Entity\MatchTeamUser $matchTeamUsers
     */
    public function addMatchTeamUser(\Club\RankingBundle\Entity\MatchTeamUser $matchTeamUsers)
    {
        $this->match_team_users[] = $matchTeamUsers;
    }

    /**
     * Get match_team_users
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMatchTeamUsers()
    {
        return $this->match_team_users;
    }
}
