<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\BookingBundle\Entity\Day
 *
 * @ORM\Table(name="club_booking_day")
 * @ORM\Entity(repositoryClass="Club\BookingBundle\Entity\DayRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Day
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
     * @var string $day
     *
     * @ORM\Column(name="day", type="string", length=255)
     */
    private $day;

    /**
     * @var datetime $open_time
     *
     * @ORM\Column(name="open_time", type="time")
     */
    private $open_time;

    /**
     * @var datetime $close_time
     *
     * @ORM\Column(name="close_time", type="time")
     */
    private $close_time;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * Set open_time
     *
     * @param datetime $openTime
     */
    public function setOpenTime($openTime)
    {
        $this->open_time = $openTime;
    }

    /**
     * Get open_time
     *
     * @return datetime
     */
    public function getOpenTime()
    {
        return $this->open_time;
    }

    /**
     * Set close_time
     *
     * @param datetime $closeTime
     */
    public function setCloseTime($closeTime)
    {
        $this->close_time = $closeTime;
    }

    /**
     * Get close_time
     *
     * @return datetime
     */
    public function getCloseTime()
    {
        return $this->close_time;
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
