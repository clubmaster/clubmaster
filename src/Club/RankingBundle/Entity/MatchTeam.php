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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
