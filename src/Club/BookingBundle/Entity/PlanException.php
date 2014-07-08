<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club\BookingBundle\Entity\PlanException
 *
 * @ORM\Table(name="club_booking_plan_exception")
 * @ORM\Entity(repositoryClass="Club\BookingBundle\Entity\PlanExceptionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PlanException
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
     * @var datetime $exclude_date
     *
     * @ORM\Column(type="datetime")
     */
    protected $exclude_date;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Plan", inversedBy="plan_exceptions")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    protected $plan;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    protected $user;


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
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }

    /**
     * Set exclude_date
     *
     * @param \DateTime $excludeDate
     * @return PlanException
     */
    public function setExcludeDate($excludeDate)
    {
        $this->exclude_date = $excludeDate;

        return $this;
    }

    /**
     * Get exclude_date
     *
     * @return \DateTime
     */
    public function getExcludeDate()
    {
        return $this->exclude_date;
    }

    /**
     * Set plan
     *
     * @param Club\BookingBundle\Entity\Plan $plan
     * @return PlanException
     */
    public function setPlan(\Club\BookingBundle\Entity\Plan $plan = null)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return Club\BookingBundle\Entity\Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     * @return PlanException
     */
    public function setUser(\Club\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
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
}
