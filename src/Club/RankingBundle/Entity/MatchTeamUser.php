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
     * @ORM\ManyToOne(targetEntity="Match")
     * @var Club\RankingBundle\Entity\Match
     */
    protected $match;

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
}
