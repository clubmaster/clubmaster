<?php

namespace Club\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\EventBundle\Repository\Attend")
 * @ORM\Table(name="club_event_attend")
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
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paid;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", onDelete="cascade")
     */
    private $event;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $created_at
     */
    private $created_at;

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
     * Set paid
     *
     * @param boolean $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }

    /**
     * Get paid
     *
     * @return boolean $paid
     */
    public function getPaid()
    {
        return $this->paid;
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
      $this->setPaid(0);
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
