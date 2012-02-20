<?php

namespace Club\RankingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\RankingBundle\Entity\Game
 *
 * @ORM\Table(name="club_ranking_game")
 * @ORM\Entity(repositoryClass="Club\RankingBundle\Entity\GameRepository")
 * @ORM\HasLifeCycleCallbacks()
 */
class Game
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var boolean $locked
     *
     * @ORM\Column(type="boolean")
     */
    private $locked;

    /**
     * @var string $type
     *
     * @ORM\Column(type="string", length=255)
     */
    private $type;

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
     * @ORM\OneToMany(targetEntity="Club\UserBundle\Entity\User", mappedBy="user")
     * @ORM\JoinTable(name="club_ranking_game_user")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Club\UserBundle\Entity\User", mappedBy="user")
     * @ORM\JoinTable(name="club_ranking_game_admins")
     */
    protected $administrators;

    /**
     * @ORM\ManyToOne(targetEntity="Rule")
     * @var Club\RankingBundle\Entity\Rule
     */
    protected $rule;


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
     * Set locked
     *
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
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
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    $this->administrators = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Get administrators
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAdministrators()
    {
        return $this->administrators;
    }

    /**
     * Set rule
     *
     * @param Club\RankingBundle\Entity\Rule $rule
     */
    public function setRule(\Club\RankingBundle\Entity\Rule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * Get rule
     *
     * @return Club\RankingBundle\Entity\Rule 
     */
    public function getRule()
    {
        return $this->rule;
    }
}