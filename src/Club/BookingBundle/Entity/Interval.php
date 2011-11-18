<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\BookingBundle\Entity\Interval
 *
 * @ORM\Table(name="club_booking_interval")
 * @ORM\Entity(repositoryClass="Club\BookingBundle\Entity\IntervalRepository")
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
     * @var integer $day_id
     *
     * @ORM\Column(name="day_id", type="integer")
     */
    private $day_id;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
