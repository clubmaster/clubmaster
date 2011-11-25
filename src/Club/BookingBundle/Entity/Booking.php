<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club\BookingBundle\Entity\Booking
 *
 * @ORM\Table(name="club_booking_booking",
 *    uniqueConstraints={@ORM\UniqueConstraint(name="unique_idx", columns={"date", "interval_id"})}
 * )
 * @ORM\Entity(repositoryClass="Club\BookingBundle\Entity\BookingRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @var date $date
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var boolean $guest
     *
     * @ORM\Column(type="boolean")
     */
    private $guest;

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
     * @ORM\ManyToMany(targetEntity="Club\UserBundle\Entity\User")
     * @ORM\JoinTable(name="club_booking_booking_user",
     *   joinColumns={@ORM\JoinColumn(name="booking_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="Interval")
     */
    private $interval;


    public function __construct()
    {
      $this->setGuest(false);
    }

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
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
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

    public function toArray()
    {
      return array(
        'id' => $this->getId(),
        'interval_id' => $this->getInterval()->getId(),
        'user_id' => $this->getUser()->getId(),
        'date' => $this->getDate()->format('c'),
        'created_at' => $this->getCreatedAt()->format('c'),
        'updated_at' => $this->getUpdatedAt()->format('c')
      );
    }

    /**
     * Set guest
     *
     * @param boolean $guest
     */
    public function setGuest($guest)
    {
        $this->guest = $guest;
    }

    /**
     * Get guest
     *
     * @return boolean
     */
    public function getGuest()
    {
        return $this->guest;
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
}
