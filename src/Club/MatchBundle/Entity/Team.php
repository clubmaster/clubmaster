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
}