<?php

namespace Club\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\MatchBundle\Entity\MatchTeamSet
 *
 * @ORM\Table(name="club_match_match_team_set")
 * @ORM\Entity(repositoryClass="Club\MatchBundle\Entity\MatchTeamSetRepository")
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
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="MatchTeam", inversedBy="match_team_set")
     * @ORM\JoinColumn(name="match_team_id", onDelete="cascade")
     *
     * @var Club\MatchBundle\Entity\MatchTeam
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
     * @param Club\MatchBundle\Entity\MatchTeam $matchTeam
     */
    public function setMatchTeam(\Club\MatchBundle\Entity\MatchTeam $matchTeam)
    {
        $this->match_team = $matchTeam;
    }

    /**
     * Get match_team
     *
     * @return Club\MatchBundle\Entity\MatchTeam
     */
    public function getMatchTeam()
    {
        return $this->match_team;
    }
}
