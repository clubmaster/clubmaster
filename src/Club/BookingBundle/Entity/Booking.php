<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\BookingBundle\Entity\Booking
 *
 * @ORM\Table(name="club_booking_booking")
 * @ORM\Entity(repositoryClass="Club\BookingBundle\Entity\BookingRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Booking
{
    const CANCELLED     = 0;
    const PENDING       = 1;
    const CONFIRMED     = 2;
    const CHECKIN       = 3;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var date $first_date
     *
     * @ORM\Column(type="datetime")
     */
    protected $first_date;

    /**
     * @var date $end_date
     *
     * @ORM\Column(type="datetime")
     */
    protected $end_date;

    /**
     * @var boolean $guest
     *
     * @ORM\Column(type="boolean")
     */
    protected $guest;

    /**
     * @var string $status
     *
     * @ORM\Column(type="string")
     */
    protected $status;

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
     * @ORM\ManyToOne(targetEntity="Field")
     */
    protected $field;

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
        'type' => 'booking',
        'field_id' => $this->getField()->getId(),
        'user' => $this->getUser()->toArray('simple'),
        'guest' => $this->getGuest(),
        'first_date' => $this->getFirstDate()->format('c'),
        'end_date' => $this->getEndDate()->format('c'),
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
        $this->status = self::PENDING;
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
     * Set end_date
     *
     * @param datetime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->end_date = $endDate;
    }

    /**
     * Get end_date
     *
     * @return datetime
     */
    public function getEndDate()
    {
        return $this->end_date;
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

    public function getFirstPartner()
    {
      if (count($this->getUsers()))

        return $this->users[0];
    }

    public function isOwner(\Club\UserBundle\Entity\User $user)
    {
      if ($user == $this->getUser()) return true;

      foreach ($this->getUsers() as $u) {
        if ($u == $user) return true;
      }

      return false;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Booking
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Remove users
     *
     * @param Club\UserBundle\Entity\User $users
     */
    public function removeUser(\Club\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }
}