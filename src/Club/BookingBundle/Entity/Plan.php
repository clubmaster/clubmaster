<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club\BookingBundle\Entity\Plan
 *
 * @ORM\Table(name="club_booking_plan")
 * @ORM\Entity(repositoryClass="Club\BookingBundle\Entity\PlanRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Plan
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
     * @var string $name
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var string $description
     *
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank()
     */
    protected $description;

    /**
     * @var boolean $repeating
     *
     * @ORM\Column(type="boolean")
     */
    protected $repeating;

    /**
     * @var boolean $all_day
     *
     * @ORM\Column(type="boolean")
     */
    protected $all_day;

    /**
     * @var date $start
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    protected $start;

    /**
     * @var date $end
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    protected $end;

    /**
     * @var date $period_start
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $period_start;

    /**
     * @var date $period_end
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $period_end;

    /**
     * @var string $day
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $day;

    /**
     * @var date $first_time
     *
     * @ORM\Column(type="time", nullable=true)
     */
    protected $first_time;

    /**
     * @var date $end_time
     *
     * @ORM\Column(type="time", nullable=true)
     */
    protected $end_time;

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
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="PlanRepeat", mappedBy="plan", cascade={"persist"})
     * @Assert\Valid()
     */
    protected $plan_repeats;

    /**
     * @ORM\ManyToMany(targetEntity="Field")
     * @ORM\JoinTable(name="club_booking_plan_field",
     *   joinColumns={@ORM\JoinColumn(name="plan_id", referencedColumnName="id", onDelete="cascade")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="field_id", referencedColumnName="id")}
     * )
     */
    protected $fields;

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
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     */
    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Club\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
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
     * Add fields
     *
     * @param Club\BookingBundle\Entity\Field $fields
     */
    public function addField(\Club\BookingBundle\Entity\Field $fields)
    {
        $this->fields[] = $fields;
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

    public function toArray()
    {
      $res = array(
        'id' => $this->getId(),
        'type' => 'plan',
        'name' => $this->getName(),
        'description' => $this->getDescription(),
        'first_date' => $this->getStart()->format('c'),
        'end_date' => $this->getEnd()->format('c'),
        'fields' => array()
      );

      foreach ($this->getFields() as $field) {
        $res['fields'][] = $field->toArray();
      }

      return $res;
    }

    /**
     * Set period_start
     *
     * @param datetime $periodStart
     */
    public function setPeriodStart($periodStart)
    {
        $this->period_start = $periodStart;
    }

    /**
     * Get period_start
     *
     * @return datetime
     */
    public function getPeriodStart()
    {
        return $this->period_start;
    }

    /**
     * Set period_end
     *
     * @param datetime $periodEnd
     */
    public function setPeriodEnd($periodEnd)
    {
        $this->period_end = $periodEnd;
    }

    /**
     * Get period_end
     *
     * @return datetime
     */
    public function getPeriodEnd()
    {
        return $this->period_end;
    }
    public function __construct()
    {
        $this->fields = new \Doctrine\Common\Collections\ArrayCollection();
        $this->start = new \DateTime(date('Y-m-d 12:00:00'));
        $this->end = new \DateTime(date('Y-m-d 13:00:00'));
        $this->all_day = false;
    }

    /**
     * Set day
     *
     * @param string $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * Get day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set first_time
     *
     * @param time $firstTime
     */
    public function setFirstTime($firstTime)
    {
        $this->first_time = $firstTime;
    }

    /**
     * Get first_time
     *
     * @return time
     */
    public function getFirstTime()
    {
        return $this->first_time;
    }

    /**
     * Set end_time
     *
     * @param time $endTime
     */
    public function setEndTime($endTime)
    {
        $this->end_time = $endTime;
    }

    /**
     * Get end_time
     *
     * @return time
     */
    public function getEndTime()
    {
        return $this->end_time;
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
     * Set all_day
     *
     * @param boolean $allDay
     * @return Plan
     */
    public function setAllDay($allDay)
    {
        $this->all_day = $allDay;

        return $this;
    }

    /**
     * Get all_day
     *
     * @return boolean
     */
    public function getAllDay()
    {
        return $this->all_day;
    }

    /**
     * Remove fields
     *
     * @param Club\BookingBundle\Entity\Field $fields
     */
    public function removeField(\Club\BookingBundle\Entity\Field $fields)
    {
        $this->fields->removeElement($fields);
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     * @return Plan
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        if ($this->getAllDay()) {
            $this->start->setTime(0,0,0);
        }
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Plan
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        if ($this->getAllDay()) {
            $this->end->setTime(23,59,59);
        }

        return $this->end;
    }

    /**
     * Add plan_repeats
     *
     * @param Club\BookingBundle\Entity\PlanRepeat $planRepeats
     * @return Plan
     */
    public function addPlanRepeat(\Club\BookingBundle\Entity\PlanRepeat $planRepeats)
    {
        $this->plan_repeats[] = $planRepeats;

        return $this;
    }

    /**
     * Remove plan_repeats
     *
     * @param Club\BookingBundle\Entity\PlanRepeat $planRepeats
     */
    public function removePlanRepeat(\Club\BookingBundle\Entity\PlanRepeat $planRepeats)
    {
        $this->plan_repeats->removeElement($planRepeats);
    }

    /**
     * Get plan_repeats
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getPlanRepeats()
    {
        return $this->plan_repeats;
    }

    /**
     * Set repeating
     *
     * @param boolean $repeating
     * @return Plan
     */
    public function setRepeating($repeating)
    {
        $this->repeating = $repeating;

        return $this;
    }

    /**
     * Get repeating
     *
     * @return boolean
     */
    public function getRepeating()
    {
        return $this->repeating;
    }

    public function getIcsUid()
    {
        return $this->getId().'_plan@clubmaster.org';
    }
}
