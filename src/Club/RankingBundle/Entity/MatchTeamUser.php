<?php

namespace Club\RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\RankingBundle\Entity\MatchTeamUser
 *
 * @ORM\Table(name="club_ranking_match_team_user")
 * @ORM\Entity(repositoryClass="Club\RankingBundle\Entity\MatchTeamUserRepository")
 */
class MatchTeamUser
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
     * @ORM\ManyToOne(targetEntity="MatchTeam")
     * @var Club\RankingBundle\Entity\MatchTeam
     */
    protected $match_team;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     * @var Club\UserBundle\Entity\User
     */
    protected $user;


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

    /**
     * Set match_team
     *
     * @param Club\RankingBundle\Entity\MatchTeam $matchTeam
     */
    public function setMatchTeam(\Club\RankingBundle\Entity\MatchTeam $matchTeam)
    {
        $this->match_team = $matchTeam;
    }

    /**
     * Get match_team
     *
     * @return Club\RankingBundle\Entity\MatchTeam
     */
    public function getMatchTeam()
    {
        return $this->match_team;
    }
}
