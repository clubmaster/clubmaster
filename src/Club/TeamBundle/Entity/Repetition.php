<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club\TeamBundle\Entity\Repetition
 *
 * @ORM\Table(name="club_team_repetition")
 * @ORM\Entity(repositoryClass="Club\TeamBundle\Entity\RepetitionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Repetition
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
     * @var string $type
     *
     * @ORM\Column(name="type", type="string")
     * @Assert\Choice({ "daily", "weekly", "monthly", "yearly" })
     */
    private $type;

    /**
     * @var datetime $first_date
     *
     * @ORM\Column(name="first_date", type="datetime")
     */
    private $first_date;

    /**
     * @var datetime $last_date
     *
     * @ORM\Column(name="last_date", type="datetime", nullable="true")
     */
    private $last_date;

    /**
     * @var end_occurrences
     *
     * @ORM\Column(name="end_occurrences", type="integer", nullable="true")
     */
    private $end_occurrences;

    /**
     * @var integer $repeat_every
     *
     * @ORM\Column(name="repeat_every", type="integer")
     */
    private $repeat_every;

    /**
     * @var string $days_in_week
     *
     * @ORM\Column(name="days_in_week", type="string", nullable="true")
     */
    private $days_in_week;

    /**
     * @var integer $day_of_month
     *
     * @ORM\Column(name="day_of_month", type="boolean", nullable="true")
     */
    private $day_of_month;

    /**
     * @var integer $week
     *
     * @ORM\Column(name="week", type="string", nullable="true")
     * @Assert\Choice({ "", "first", "second", "third", "fourth", "last"})
     */
    private $week;

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
     * @ORM\OneToOne(targetEntity="Schedule")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id", onDelete="cascade")
     */
    private $schedule;


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
     * Set last_date
     *
     * @param datetime $lastDate
     */
    public function setLastDate($lastDate)
    {
        $this->last_date = $lastDate;
    }

    /**
     * Get last_date
     *
     * @return datetime
     */
    public function getLastDate()
    {
        return $this->last_date;
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
     * Set end_occurrences
     *
     * @param integer $endOccurrences
     */
    public function setEndOccurrences($endOccurrences)
    {
        $this->end_occurrences = $endOccurrences;
    }

    /**
     * Get end_occurrences
     *
     * @return integer
     */
    public function getEndOccurrences()
    {
        return $this->end_occurrences;
    }

    /**
     * Set repeat_every
     *
     * @param integer $repeatEvery
     */
    public function setRepeatEvery($repeatEvery)
    {
        $this->repeat_every = $repeatEvery;
    }

    /**
     * Get repeat_every
     *
     * @return integer
     */
    public function getRepeatEvery()
    {
        return $this->repeat_every;
    }

    /**
     * Set days_in_week
     *
     * @param string $daysInWeek
     */
    public function setDaysInWeek($daysInWeek)
    {
        $this->days_in_week = serialize($daysInWeek);
    }

    /**
     * Get days_in_week
     *
     * @return string
     */
    public function getDaysInWeek()
    {
      if (!unserialize($this->days_in_week))
        return array();

      return unserialize($this->days_in_week);
    }

    /**
     * Set day_of_month
     *
     * @param boolean $dayOfMonth
     */
    public function setDayOfMonth($dayOfMonth)
    {
        $this->day_of_month = $dayOfMonth;
    }

    /**
     * Get day_of_month
     *
     * @return boolean
     */
    public function getDayOfMonth()
    {
        return $this->day_of_month;
    }

    /**
     * Set week
     *
     * @param string $week
     */
    public function setWeek($week)
    {
        $this->week = $week;
    }

    /**
     * Get week
     *
     * @return string
     */
    public function getWeek()
    {
        return $this->week;
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
