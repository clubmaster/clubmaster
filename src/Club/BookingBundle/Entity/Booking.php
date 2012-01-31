<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club\BookingBundle\Entity\Booking
 *
 * @ORM\Table(name="club_booking_booking")
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
    protected $id;

    /**
     * @var date $start_date
     *
     * @ORM\Column(type="datetime")
     */
    protected $start_date;

    /**
     * @var date $stop_date
     *
     * @ORM\Column(type="datetime")
     */
    protected $stop_date;

    /**
     * @var boolean $guest
     *
     * @ORM\Column(type="boolean")
     */
    protected $guest;

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
     * @ORM\ManyToMany(targetEntity="Club\UserBundle\Entity\User")
     * @ORM\JoinTable(name="club_booking_booking_user",
     *   joinColumns={@ORM\JoinColumn(name="booking_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    protected $users;


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
      // FIXME, there might be a problem if we cross multiple days, check up on this..
      $interval = $this->interval;
      $interval->getStartTime()->setDate(
        $this->getStartDate()->format('Y'),
        $this->getStartDate()->format('m'),
        $this->getStartDate()->format('d')
      );
      $interval->getStopTime()->setDate(
        $this->getStopDate()->format('Y'),
        $this->getStopDate()->format('m'),
        $this->getStopDate()->format('d')
      );

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
      $ret = array(
        'id' => $this->getId(),
        'interval_id' => $this->getInterval()->getId(),
        'user' => $this->getUser()->toArray('simple'),
        'guest' => $this->getGuest(),
        'start_date' => $this->getStartDate()->format('c'),
        'stop_date' => $this->getStopDate()->format('c'),
        'created_at' => $this->getCreatedAt()->format('c'),
        'updated_at' => $this->getUpdatedAt()->format('c')
      );

      if (count($this->getUsers())) {
        $ret['users'] = array();
        foreach ($this->getUsers() as $user) {
          $ret['users'][] = $user->toArray('simple');
        }
      }

      return $ret;
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
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set start_date
     *
     * @param datetime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
    }

    /**
     * Get start_date
     *
     * @return datetime
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set stop_date
     *
     * @param datetime $stopDate
     */
    public function setStopDate($stopDate)
    {
        $this->stop_date = $stopDate;
    }

    /**
     * Get stop_date
     *
     * @return datetime
     */
    public function getStopDate()
    {
        return $this->stop_date;
    }
}
