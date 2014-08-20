<?php

namespace Club\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club\MatchBundle\Entity\League
 *
 * @ORM\Table(name="club_match_league")
 * @ORM\Entity(repositoryClass="Club\MatchBundle\Entity\LeagueRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class League
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
     * @var string $gender
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Choice(choices = {"male", "female", ""})
     */
    private $gender;

    /**
     * @var boolean $invite_only
     *
     * @ORM\Column(type="boolean")
     */
    private $invite_only;

    /**
     * @var string $game_set
     *
     * @ORM\Column(type="integer")
     */
    private $game_set;

    /**
     * @var string $type
     *
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @var datetime $start_date
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    private $start_date;

    /**
     * @var datetime $end_date
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end_date;

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
     * @ORM\ManyToMany(targetEntity="Club\UserBundle\Entity\User")
     * @ORM\JoinTable(name="club_match_league_user")
     */
    protected $users;

    /**
     * @ORM\ManyToOne(targetEntity="Rule")
     * @var Club\MatchBundle\Entity\Rule
     */
    protected $rule;

    /**
     * @ORM\OneToMany(targetEntity="Club\MatchBundle\Entity\Match", mappedBy="league")
     */
    protected $matches;

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

    /**
     * Set rule
     *
     * @param Club\MatchBundle\Entity\Rule $rule
     */
    public function setRule(\Club\MatchBundle\Entity\Rule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * Get rule
     *
     * @return Club\MatchBundle\Entity\Rule
     */
    public function getRule()
    {
        return $this->rule;
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
     * Set invite_only
     *
     * @param boolean $inviteOnly
     */
    public function setInviteOnly($inviteOnly)
    {
        $this->invite_only = $inviteOnly;
    }

    /**
     * Get invite_only
     *
     * @return boolean
     */
    public function getInviteOnly()
    {
        return $this->invite_only;
    }

    /**
     * Add matches
     *
     * @param Club\MatchBundle\Entity\Match $matches
     */
    public function addMatch(\Club\MatchBundle\Entity\Match $matches)
    {
        $this->matches[] = $matches;
    }

    public function setMatches($matches)
    {
      $this->matches = $matches;
    }

    /**
     * Get matches
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * Set start_date
     *
     * @param datetime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
    }

    /**
     * Get start_date
     *
     * @return datetime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set end_date
     *
     * @param datetime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;
    }

    /**
     * Get end_date
     *
     * @return datetime
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    public function isOpen()
    {
      $t = new \DateTime();

      if ($this->getStartDate() < $t && ($this->getEndDate() == null || $this->getEndDate() > $t)) return true;

      return false;
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

    public function __construct()
    {
      $this->users = new \Doctrine\Common\Collections\ArrayCollection();
      $this->matches = new \Doctrine\Common\Collections\ArrayCollection();
      $this->type = '1-on-1';
    }

    public function canPlay(\Club\UserBundle\Entity\User $user)
    {
      foreach ($this->getUsers() as $u) {
        if ($u == $user) return true;
      }

      return false;
    }

    /**
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender)
    {
      if (!strlen($gender)) {
        $this->gender = null;
      } else {
        $this->gender = $gender;
      }
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Remove users
     *
     * @param Club\UserBundle\Entity\User $users
     */
    public function removeUser(\Club\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Add matches
     *
     * @param Club\MatchBundle\Entity\Match $matches
     * @return League
     */
    public function addMatche(\Club\MatchBundle\Entity\Match $matches)
    {
        $this->matches[] = $matches;

        return $this;
    }

    /**
     * Remove matches
     *
     * @param Club\MatchBundle\Entity\Match $matches
     */
    public function removeMatche(\Club\MatchBundle\Entity\Match $matches)
    {
        $this->matches->removeElement($matches);
    }
}
