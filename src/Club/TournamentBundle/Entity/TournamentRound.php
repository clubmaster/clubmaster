<?php

namespace Club\TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\TournamentBundle\Entity\TournamentRound
 *
 * @ORM\Table(name="club_tournament_tournament_round")
 * @ORM\Entity(repositoryClass="Club\TournamentBundle\Entity\TournamentRoundRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class TournamentRound
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
     * @var integer $round
     *
     * @ORM\Column(name="round", type="integer")
     */
    private $round;

    /**
     * @var string $round_name
     *
     * @ORM\Column(name="round_name", type="string", length=255)
     */
    private $round_name;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="Tournament")
     */
    private $tournament;

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
     * Set round
     *
     * @param integer $round
     */
    public function setRound($round)
    {
        $this->round = $round;
    }

    /**
     * Get round
     *
     * @return integer
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Set round_name
     *
     * @param string $roundName
     */
    public function setRoundName($roundName)
    {
        $this->round_name = $roundName;
    }

    /**
     * Get round_name
     *
     * @return string
     */
    public function getRoundName()
    {
        return $this->round_name;
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
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set tournament
     *
     * @param Club\TournamentBundle\Entity\Tournament $tournament
     */
    public function setTournament(\Club\TournamentBundle\Entity\Tournament $tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * Get tournament
     *
     * @return Club\TournamentBundle\Entity\Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }
}
