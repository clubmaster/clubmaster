<?php

namespace Club\TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\TournamentBundle\Entity\Tournament
 *
 * @ORM\Table(name="club_tournament_tournament")
 * @ORM\Entity(repositoryClass="Club\TournamentBundle\Entity\TournamentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Tournament
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer $min_attend
     *
     * @ORM\Column(name="min_attend", type="integer")
     */
    private $min_attend;

    /**
     * @var integer $max_attend
     *
     * @ORM\Column(name="max_attend", type="integer", nullable=true)
     */
    private $max_attend;

    /**
     * @var integer $seeds
     *
     * @ORM\Column(name="seeds", type="integer", nullable=true)
     */
    private $seeds;

    /**
     * @var integer $build
     *
     * @ORM\Column(name="build", type="boolean")
     */
    private $build;

    /**
     * @var integer $rounds
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rounds;

    /**
     * @var datetime $start_time
     *
     * @ORM\Column(name="start_time", type="datetime")
     */
    private $start_time;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * @var Club\TournamentBundle\Entity\Attend
     *
     * @ORM\OneToMany(targetEntity="Attend", mappedBy="tournament")
     */
    protected $attends;


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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set max_attend
     *
     * @param integer $maxAttend
     */
    public function setMaxAttend($maxAttend)
    {
        $this->max_attend = $maxAttend;
    }

    /**
     * Get max_attend
     *
     * @return integer
     */
    public function getMaxAttend()
    {
        return $this->max_attend;
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
     * Set seeds
     *
     * @param integer $seeds
     */
    public function setSeeds($seeds)
    {
        $this->seeds = $seeds;
    }

    /**
     * Get seeds
     *
     * @return integer
     */
    public function getSeeds()
    {
        return $this->seeds;
    }

    /**
     * Set start_time
     *
     * @param datetime $startTime
     */
    public function setStartTime($startTime)
    {
        $this->start_time = $startTime;
    }

    /**
     * Get start_time
     *
     * @return datetime
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
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
     * @ORM\preUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    public function __construct()
    {
      $this->setBuild(false);
      $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set min_attend
     *
     * @param integer $minAttend
     */
    public function setMinAttend($minAttend)
    {
        $this->min_attend = $minAttend;
    }

    /**
     * Get min_attend
     *
     * @return integer
     */
    public function getMinAttend()
    {
        return $this->min_attend;
    }

    /**
     * Set rounds
     *
     * @param integer $rounds
     */
    public function setRounds($rounds)
    {
        $this->rounds = $rounds;
    }

    /**
     * Get rounds
     *
     * @return integer
     */
    public function getRounds()
    {
        return $this->rounds;
    }

    /**
     * Add attends
     *
     * @param Club\TournamentBundle\Entity\Attend $attends
     */
    public function addAttend(\Club\TournamentBundle\Entity\Attend $attends)
    {
        $this->attends[] = $attends;
    }

    /**
     * Get attends
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getAttends()
    {
        return $this->attends;
    }

    /**
     * Set build
     *
     * @param boolean $build
     */
    public function setBuild($build)
    {
        $this->build = $build;
    }

    /**
     * Get build
     *
     * @return boolean
     */
    public function getBuild()
    {
        return $this->build;
    }
}
