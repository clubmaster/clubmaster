<?php

namespace Club\RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\RankingBundle\Entity\MatchSet
 *
 * @ORM\Table(name="club_ranking_match_set")
 * @ORM\Entity(repositoryClass="Club\RankingBundle\Entity\MatchSetRepository")
 */
class MatchSet
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
     * @ORM\ManyToOne(targetEntity="Match")
     * @ORM\JoinColumn(name="match_id", onDelete="cascade")
     *
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
}