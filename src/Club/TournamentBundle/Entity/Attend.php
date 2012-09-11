<?php

namespace Club\TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\TournamentBundle\Entity\Attend
 *
 * @ORM\Table(name="club_tournament_tournament_attend", uniqueConstraints={@ORM\UniqueConstraint(name="uniq_idx", columns={"tournament_id","user_id"})})
 * @ORM\Entity(repositoryClass="Club\TournamentBundle\Entity\AttendRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Attend
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
     * @var integer $seed
     *
     * @ORM\Column(name="seed", type="integer", nullable="true")
     */
    private $seed;

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
     * @var object $tournament
     *
     * @ORM\ManyToOne(targetEntity="Tournament")
     */
    private $tournament;

    /**
     * @var object $user
     *
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    private $user;

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
     * Set seed
     *
     * @param integer $seed
     */
    public function setSeed($seed)
    {
        $this->seed = $seed;
    }

    /**
     * Get seed
     *
     * @return integer
     */
    public function getSeed()
    {
        return $this->seed;
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
     * Set tournament
     *
     * @param object $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * Get tournament
     *
     * @return object
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * Set user
     *
     * @param object $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return object
     */
    public function getUser()
    {
        return $this->user;
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
}
