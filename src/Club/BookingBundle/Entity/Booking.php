<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\BookingBundle\Entity\Booking
 *
 * @ORM\Table(name="club_booking_booking")
 * @ORM\Entity(repositoryClass="Club\BookingBundle\Entity\BookingRepository")
 */
class Booking
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
     * @var date $booking_date
     *
     * @ORM\Column(name="booking_date", type="date")
     */
    private $booking_date;

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
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Interval")
     */
    private $interval;


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
     * Set booking_date
     *
     * @param date $bookingDate
     */
    public function setBookingDate($bookingDate)
    {
        $this->booking_date = $bookingDate;
    }

    /**
     * Get booking_date
     *
     * @return date
     */
    public function getBookingDate()
    {
        return $this->booking_date;
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
     * Set interval
     *
     * @param Club\BookingBundle\Entity\Interval $interval
     */
    public function setInterval(\Club\BookingBundle\Entity\Interval $interval)
    {
        $this->interval = $interval;
    }

    /**
     * Get interval
     *
     * @return Club\BookingBundle\Entity\Interval 
     */
    public function getInterval()
    {
        return $this->interval;
    }
}