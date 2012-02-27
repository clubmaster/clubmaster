<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;


/**
 * Club\TeamBundle\Entity\ScheduleUser
 *
 * @ORM\Table(name="club_team_schedule_user",
 *    uniqueConstraints={@ORM\UniqueConstraint(name="unique_idx", columns={"user_id","schedule_id"})}
 * )
 * @ORM\Entity(repositoryClass="Club\TeamBundle\Entity\ScheduleUserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Assert\Callback(groups={"attend"}, methods={"isFull","isExpired"})
 */
class ScheduleUser
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
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Club\TeamBundle\Entity\Schedule")
     */
    protected $schedule;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;


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
    }

    /**
     * Set schedule
     *
     * @param Club\TeamBundle\Entity\Schedule $schedule
     */
    public function setSchedule(\Club\TeamBundle\Entity\Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Get schedule
     *
     * @return Club\TeamBundle\Entity\Schedule
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    public function isFull(ExecutionContext $context)
    {
      if (count($this->getSchedule()->getUsers()) >= $this->getSchedule()->getMaxAttend()) {
        $property_path = $context->getPropertyPath() . '.users';
        $context->setPropertyPath($property_path);
        $context->addViolation('The team is already full!', array(), null);
      }
    }

    public function isExpired(ExecutionContext $context)
    {
      if ($this->getSchedule()->getFirstDate()->getTimestamp() < time()) {
        $property_path = $context->getPropertyPath() . '.users';
        $context->setPropertyPath($property_path);
        $context->addViolation('The team is already started!', array(), null);
      }
    }
}
