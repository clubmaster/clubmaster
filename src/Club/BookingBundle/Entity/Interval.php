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
     * @var integer $day
     *
     * @ORM\Column(type="integer")
     */
    private $day;

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
     * @ORM\ManyToOne(targetEntity="Field")
     */
    private $field;

    /**
     * Virtual variable
     */
    private $booking;

    /**
     * Virtual variable
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
     * Set day
     *
     * @param integer $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * Get day
     *
     * @return integer
     */
    public function getDay()
    {
        return $this->day;
    }

    public function getDiff()
    {
      $diff = $this->getStartTime()->diff($this->getStopTime());

      $min = 0;
      if ($diff->d > 0)
        $min += $diff->d*24*60;
      if ($diff->h > 0)
        $min += $diff->h*60;
      if ($diff->i > 0)
        $min += $diff->i;

      return $min;
    }

    public function toArray()
    {
      $res = array(
        'id' => $this->getId(),
        'start_time' => $this->getStartTime()->format('c'),
        'end_time' => $this->getStopTime()->format('c'),
        'day' => $this->getDay(),
        'field' => $this->getField()->getId()
      );

      if (isset($this->booking))
        $res['booking'] = $this->booking->toArray();
      if (isset($this->schedule))
        $res['schedule'] = $this->schedule->toArray();

      return $res;
    }

    public function setBooking(\Club\BookingBundle\Entity\Booking $booking)
    {
      $this->booking = $booking;
    }

    public function getBooking()
    {
      return $this->booking;
    }

    public function setSchedule(\Club\TeamBundle\Entity\Schedule $schedule)
    {
      $this->schedule = $schedule;
    }

    public function getSchedule()
    {
      return $this->schedule;
    }

    /**
     * Set field
     *
     * @param Club\BookingBundle\Entity\Field $field
     */
    public function setField(\Club\BookingBundle\Entity\Field $field)
    {
        $this->field = $field;
    }

    /**
     * Get field
     *
     * @return Club\BookingBundle\Entity\Field
     */
    public function getField()
    {
        return $this->field;
    }
}
