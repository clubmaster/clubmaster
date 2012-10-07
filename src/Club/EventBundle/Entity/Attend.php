<?php

namespace Club\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\EventBundle\Entity\AttendRepository")
 * @ORM\Table(name="club_event_attend",
 *    uniqueConstraints={@ORM\UniqueConstraint(name="unique_idx", columns={"user_id","event_id"})}
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Attend
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User", inversedBy="attends")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="attends")
     * @ORM\JoinColumn(name="event_id", onDelete="cascade")
     */
    protected $event;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $created_at
     */
    protected $created_at;

    /**
     * Get id
     *
     * @return integer $id
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
     * @return datetime $createdAt
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
     * @return Club\UserBundle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set event
     *
     * @param Club\EventBundle\Entity\Event $event
     */
    public function setEvent(\Club\EventBundle\Entity\Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get event
     *
     * @return Club\EventBundle\Entity\Event $event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }

    /**
     * @Assert\True(message = "No more attends allowed")
     *
     */
    public function isAllowed()
    {
      if ($this->getEvent()->getMaxAttends() == null) return true;

      if (count($this->getEvent()->getAttends()) >= $this->getEvent()->getMaxAttends())

        return false;

      return true;
    }
}
