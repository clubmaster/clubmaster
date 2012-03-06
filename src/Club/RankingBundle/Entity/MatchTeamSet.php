<?php

namespace Club\RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\RankingBundle\Entity\MatchTeamSet
 *
 * @ORM\Table(name="club_ranking_match_team_set")
 * @ORM\Entity(repositoryClass="Club\RankingBundle\Entity\MatchTeamSetRepository")
 */
class MatchTeamSet
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
     * @var string $game_set
     *
     * @ORM\Column(type="integer")
     */
    private $game_set;

    /**
     * @var string $value
     *
     * @ORM\Column(type="string", length="255")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="MatchTeam")
     * @ORM\JoinColumn(name="match_team_id", onDelete="cascade")
     *
     * @var Club\RankingBundle\Entity\MatchTeam
     */
    protected $match_team;


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
     * Set game_set
     *
     * @param integer $gameSet
     */
    public function setGameSet($gameSet)
    {
        $this->game_set = $gameSet;
    }

    /**
     * Get game_set
     *
     * @return integer
     */
    public function getGameSet()
    {
        return $this->game_set;
    }

    /**
     * Set value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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