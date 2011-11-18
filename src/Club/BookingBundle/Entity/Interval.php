<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\BookingBundle\Entity\Interval
 *
 * @ORM\Table(name="club_booking_interval")
 * @ORM\Entity(repositoryClass="Club\BookingBundle\Entity\IntervalRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Interval
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
     * @var time $start_time
     *
     * @ORM\Column(type="time")
     */
    private $start_time;

    /**
     * @var time $stop_time
     *
     * @ORM\Column(type="time")
     */
    private $stop_time;

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
     * @ORM\ManyToOne(targetEntity="Day")
     */
    private $day;


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
     * Set start_time
     *
     * @param time $startTime
     */
    public function setStartTime($startTime)
    {
        $this->start_time = $startTime;
    }

    /**
     * Get start_time
     *
     * @return time
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * Set stop_time
     *
     * @param time $stopTime
     */
    public function setStopTime($stopTime)
    {
        $this->stop_time = $stopTime;
    }

    /**
     * Get stop_time
     *
     * @return time
     */
    public function getStopTime()
    {
        return $this->stop_time;
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
     * Set day
     *
     * @param Club\BookingBundle\Entity\Day $day
     */
    public function setDay(\Club\BookingBundle\Entity\Day $day)
    {
        $this->day = $day;
    }

    /**
     * Get day
     *
     * @return Club\BookingBundle\Entity\Day
     */
    public function getDay()
    {
        return $this->day;
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
}
