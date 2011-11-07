<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var datetime $first_date
     *
     * @ORM\Column(name="first_date", type="datetime")
     */
    private $first_date;

    /**
     * @var datetime $last_date
     *
     * @ORM\Column(name="last_date", type="datetime")
     */
    private $last_date;

    /**
     * @var integer $day_period
     *
     * @ORM\Column(name="day_period", type="integer")
     */
    private $day_period;

    /**
     * @var integer $day_of_month
     *
     * @ORM\Column(name="day_of_month", type="integer")
     */
    private $day_of_month;

    /**
     * @var integer $day_of_week
     *
     * @ORM\Column(name="day_of_week", type="integer")
     */
    private $day_of_week;

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
     * @ORM\ManyToOne(targetEntity="Team")
     */
    private $team;


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
     * Set day_period
     *
     * @param integer $dayPeriod
     */
    public function setDayPeriod($dayPeriod)
    {
        $this->day_period = $dayPeriod;
    }

    /**
     * Get day_period
     *
     * @return integer
     */
    public function getDayPeriod()
    {
        return $this->day_period;
    }

    /**
     * Set day_of_month
     *
     * @param integer $dayOfMonth
     */
    public function setDayOfMonth($dayOfMonth)
    {
        $this->day_of_month = $dayOfMonth;
    }

    /**
     * Get day_of_month
     *
     * @return integer
     */
    public function getDayOfMonth()
    {
        return $this->day_of_month;
    }

    /**
     * Set day_of_week
     *
     * @param integer $dayOfWeek
     */
    public function setDayOfWeek($dayOfWeek)
    {
        $this->day_of_week = $dayOfWeek;
    }

    /**
     * Get day_of_week
     *
     * @return integer
     */
    public function getDayOfWeek()
    {
        return $this->day_of_week;
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
}
