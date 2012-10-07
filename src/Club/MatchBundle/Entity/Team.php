<?php

namespace Club\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\MatchBundle\Entity\Team
 *
 * @ORM\Table(name="club_match_team")
 * @ORM\Entity(repositoryClass="Club\MatchBundle\Entity\TeamRepository")
 */
class Team
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
     * @var Club\UserBundle\Entity\User
     *
     * @ORM\ManyToMany(targetEntity="Club\UserBundle\Entity\User")
     * @ORM\JoinTable(name="club_match_team_user")
     */
    protected $users;

    /**
     * @var Club\MatchBundle\Entity\MatchTeam
     *
     * @ORM\OneToMany(targetEntity="MatchTeam", mappedBy="team")
     */
    protected $match_teams;

    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getTeamName()
    {
      $res = array();
      foreach ($this->getUsers() as $user) {
        $res[] = $user->getName();
      }

      return implode(' - ', $res);
    }

    /**
     * Add users
     *
     * @param Club\UserBundle\Entity\User $users
     */
    public function addUser(\Club\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;
    }

    /**
     * Get users
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Remove users
     *
     * @param Club\UserBundle\Entity\User $users
     */
    public function removeUser(\Club\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Add match_teams
     *
     * @param Club\MatchBundle\Entity\MatchTeam $matchTeams
     * @return Team
     */
    public function addMatchTeam(\Club\MatchBundle\Entity\MatchTeam $matchTeams)
    {
        $this->match_teams[] = $matchTeams;

        return $this;
    }

    /**
     * Remove match_teams
     *
     * @param Club\MatchBundle\Entity\MatchTeam $matchTeams
     */
    public function removeMatchTeam(\Club\MatchBundle\Entity\MatchTeam $matchTeams)
    {
        $this->match_teams->removeElement($matchTeams);
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
}