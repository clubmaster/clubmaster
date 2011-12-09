<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;


/**
 * Club\TeamBundle\Entity\Schedule
 *
 * @ORM\Table(name="club_team_schedule")
 * @ORM\Entity(repositoryClass="Club\TeamBundle\Entity\ScheduleRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Assert\Callback(groups={"attend"}, methods={"isFull","isExpired"})
 */
class Schedule
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    protected $description;

    /**
     * @var text $penalty
     *
     * @ORM\Column(name="penalty", type="decimal", scale="2")
     * @Assert\NotBlank()
     */
    protected $penalty;

    /**
     * @var text $max_attend
     *
     * @ORM\Column(name="max_attend", type="integer")
     * @Assert\NotBlank()
     */
    protected $max_attend;

    /**
     * @var datetime $first_date
     *
     * @ORM\Column(name="first_date", type="datetime")
     */
    protected $first_date;

    /**
     * @var datetime $end_date
     *
     * @ORM\Column(name="end_date", type="datetime", nullable="true")
     */
    protected $end_date;

    /**
     * @var datetime $processed
     *
     * @ORM\Column(name="processed", type="boolean")
     */
    protected $processed;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $team;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\Location")
     */
    protected $location;

    /**
     * @ORM\ManyToOne(targetEntity="Schedule")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $schedule;

    /**
     * @ORM\OneToMany(targetEntity="Schedule", mappedBy="schedule")
     */
    protected $schedules;

    /**
     * @ORM\ManyToMany(targetEntity="Club\UserBundle\Entity\User")
     * @ORM\JoinTable(name="club_team_schedule_instructor")
     */
    protected $instructors;

    /**
     * @ORM\OneToMany(targetEntity="Club\TeamBundle\Entity\ScheduleUser", mappedBy="schedule")
     * @ORM\JoinTable(name="club_team_schedule_user")
     */
    protected $users;

    /**
     * @ORM\ManyToMany(targetEntity="Club\BookingBundle\Entity\Field")
     * @ORM\JoinTable(name="club_team_schedule_field")
     */
    protected $fields;

    /**
     * @ORM\ManyToOne(targetEntity="Level")
     */
    protected $level;

    /**
     * @ORM\OneToOne(targetEntity="Repetition")
     * @ORM\JoinColumn(name="repetition_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $repetition;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->instructors = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set first_date
     *
     * @param datetime $firstDate
     */
    public function setFirstDate($firstDate)
    {
        $this->first_date = $firstDate;
    }

    /**
     * Get first_date
     *
     * @return datetime
     */
    public function getFirstDate()
    {
        return $this->first_date;
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
     * Set team
     *
     * @param Club\TeamBundle\Entity\Team $team
     */
    public function setTeam(\Club\TeamBundle\Entity\Team $team)
    {
        $this->team = $team;
    }

    /**
     * Get team
     *
     * @return Club\TeamBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Get instructors
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getInstructors()
    {
        return $this->instructors;
    }

    /**
     * Set level
     *
     * @param Club\TeamBundle\Entity\Level $level
     */
    public function setLevel(\Club\TeamBundle\Entity\Level $level)
    {
        $this->level = $level;
    }

    /**
     * Get level
     *
     * @return Club\TeamBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setProcessed(false);
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
     * Set schedule
     *
     * @param Club\TeamBundle\Entity\Schedule $schedule
     */
    public function setSchedule(\Club\TeamBundle\Entity\Schedule $schedule=null)
    {
        $this->schedule = $schedule;
    }

    /**
     * Get schedule
     *
     * @return Club\TeamBundle\Entity\Schedule
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Add schedules
     *
     * @param Club\TeamBundle\Entity\Schedule $schedules
     */
    public function addSchedule(\Club\TeamBundle\Entity\Schedule $schedules)
    {
        $this->schedules[] = $schedules;
    }

    /**
     * Get schedules
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    /**
     * Set repetition
     *
     * @param Club\TeamBundle\Entity\Repetition $repetition
     */
    public function setRepetition(\Club\TeamBundle\Entity\Repetition $repetition=null)
    {
        $this->repetition = $repetition;
    }

    /**
     * Get repetition
     *
     * @return Club\TeamBundle\Entity\Repetition
     */
    public function getRepetition()
    {
        return $this->repetition;
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
     * Add instructors
     *
     * @param Club\UserBundle\Entity\User $instructors
     */
    public function addInstructor(\Club\UserBundle\Entity\User $instructors)
    {
      if (!$this->hasInstructor($instructors))
        $this->instructors[] = $instructors;
    }

    public function hasInstructor(\Club\UserBundle\Entity\User $instructor)
    {
      foreach ($this->getInstructors() as $inst) {
        if ($inst == $instructor) return true;
      }

      return false;
    }

    /**
     * Add users
     *
     * @param Club\UserBundle\Entity\User $users
     */
    public function addUser(\Club\UserBundle\Entity\User $user)
    {
      foreach ($user->getSubscriptions() as $subscription) {
        if ($subscription->hasAttribute('team')) {
          foreach ($subscription->getLocation() as $location) {

            if ($location == $this->getLocation()) {
              $this->users[] = $user;
              return true;
            }

            foreach ($subscription->getLocation() as $child) {
              if ($child == $this->getLocation()) {
                $this->users[] = $user;
                return true;
              }

              foreach ($child->getChilds() as $child2) {
                if ($child2 == $this->getLocation()) {
                  $this->users[] = $user;
                  return true;
                }
              }

              foreach ($child2->getChilds() as $child3) {
                if ($child3 == $this->getLocation()) {
                  $this->users[] = $user;
                  return true;
                }

                foreach ($child3->getChilds() as $child4) {
                  if ($child4 == $this->getLocation()) {
                    $this->users[] = $user;
                    return true;
                  }
                }
              }
            }
          }
        }
      }

      return false;
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

    public function toArray()
    {
      $res = array(
        'id' => $this->getId(),
        'team_name' => $this->getTeam()->getTeamName(),
        'description' => $this->getDescription(),
        'level' => $this->getLevel()->getLevelName(),
        'first_date' => $this->getFirstDate()->format('c'),
        'end_date' => $this->getEndDate()->format('c'),
        'max_attend' => $this->getMaxAttend(),
        'users' => array(),
        'instructors' => array()
      );

      foreach ($this->getUsers() as $user) {
        $res['users'][] = array('user_id' => $user->getId());
      }
      foreach ($this->getInstructors() as $user) {
        $res['instructors'][] = array('user_id' => $user->getId());
      }

      return $res;
    }

    /**
     * Set location
     *
     * @param Club\UserBundle\Entity\Location $location
     */
    public function setLocation(\Club\UserBundle\Entity\Location $location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return Club\UserBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    public function isFull(ExecutionContext $context)
    {
      if (count($this->getUsers()) > $this->getMaxAttend()) {
        $property_path = $context->getPropertyPath() . '.users';
        $context->setPropertyPath($property_path);
        $context->addViolation('The team is already full!', array(), null);
      }
    }

    public function isExpired(ExecutionContext $context)
    {
      if ($this->getFirstDate()->getTimestamp() < time()) {
        $property_path = $context->getPropertyPath() . '.users';
        $context->setPropertyPath($property_path);
        $context->addViolation('The team is already started!', array(), null);
      }
    }

    public function resetInstructors()
    {
      $this->instructors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set penalty
     *
     * @param decimal $penalty
     */
    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;
    }

    /**
     * Get penalty
     *
     * @return decimal
     */
    public function getPenalty()
    {
        return $this->penalty;
    }

    /**
     * Set processed
     *
     * @param boolean $processed
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;
    }

    /**
     * Get processed
     *
     * @return boolean
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * Add fields
     *
     * @param Club\BookingBundle\Entity\Field $fields
     */
    public function addField(\Club\BookingBundle\Entity\Field $fields)
    {
        $this->fields[] = $fields;
    }

    /**
     * Set fields
     *
     * @param Doctrine\Common\Collections\Collection $fields
     */
    public function setFields(\Doctrine\Common\Collections\Collection $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Get fields
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFields()
    {
        return $this->fields;
    }
}
