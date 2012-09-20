<?php

namespace Club\RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\RankingBundle\Entity\RankingEntry
 *
 * @ORM\Table(name="club_ranking_ranking_entry")
 * @ORM\Entity(repositoryClass="Club\RankingBundle\Entity\RankingEntryRepository")
 * @ORM\HasLifeCycleCallbacks()
 *
 */
class RankingEntry
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
     * @var integer $played
     *
     * @ORM\Column(type="integer")
     */
    private $played;

    /**
     * @var integer $won
     *
     * @ORM\Column(type="integer")
     */
    private $won;

    /**
     * @var integer $lost
     *
     * @ORM\Column(type="integer")
     */
    private $lost;

    /**
     * @var integer $point
     *
     * @ORM\Column(type="integer")
     */
    private $point;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="Ranking")
     * @ORM\JoinColumn(onDelete="cascade")
     *
     * @var Club\RankingBundle\Entity\Ranking
     */
    protected $ranking;

    /**
     * @ORM\ManyToOne(targetEntity="Club\MatchBundle\Entity\Team")
     * @ORM\JoinColumn(onDelete="cascade")
     *
     * @var Club\MatchBundle\Entity\Team
     */
    protected $team;

    public function __construct()
    {
      $this->won = 0;
      $this->lost = 0;
      $this->point = 0;
      $this->played = 0;
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

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set played
     *
     * @param integer $played
     */
    public function setPlayed($played)
    {
        $this->played = $played;
    }

    /**
     * Get played
     *
     * @return integer
     */
    public function getPlayed()
    {
        return $this->played;
    }

    /**
     * Set won
     *
     * @param integer $won
     */
    public function setWon($won)
    {
        $this->won = $won;
    }

    /**
     * Get won
     *
     * @return integer
     */
    public function getWon()
    {
        return $this->won;
    }

    /**
     * Set lost
     *
     * @param integer $lost
     */
    public function setLost($lost)
    {
        $this->lost = $lost;
    }

    /**
     * Get lost
     *
     * @return integer
     */
    public function getLost()
    {
        return $this->lost;
    }

    /**
     * Set point
     *
     * @param integer $point
     */
    public function setPoint($point)
    {
      if ($point < 0)
        $point = 0;

      $this->point = $point;
    }

    /**
     * Get point
     *
     * @return integer
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set ranking
     *
     * @param Club\RankingBundle\Entity\Ranking $ranking
     */
    public function setRanking(\Club\RankingBundle\Entity\Ranking $ranking)
    {
        $this->ranking = $ranking;
    }

    /**
     * Get ranking
     *
     * @return Club\RankingBundle\Entity\Ranking
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    public function getPercentWon()
    {
      if (!$this->getPlayed()) return 0;

      return sprintf('%d', $this->getWon()/$this->getPlayed()*100);
    }
}
