<?php

namespace Club\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\MessageBundle\Repository\Message")
 * @ORM\Table(name="club_message_message")
 * @ORM\HasLifecycleCallbacks()
 */
class Message
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
     * @ORM\Column(type="string")
     *
     * @var string $subject
     */
    private $subject;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $type
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     *
     * @var text $message
     */
    private $message;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $sender_name
     */
    private $sender_name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $sender_address
     */
    private $sender_address;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var text $processed
     */
    private $processed;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     *
     * @var text $sent_at
     */
    private $sent_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var text $updated_at
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var text $created_at
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity="MessageQueue", mappedBy="message")
     *
     * @var Club\MessageBundle\Entity\MessageQueue
     */
    private $message_queue;

    /**
     * @ORM\ManytoMany(targetEntity="Club\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="club_message_message_group",
     *   joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     *
     * @var Club\UserBundle\Entity\Group
     */
    private $groups;

    /**
     * @ORM\ManytoMany(targetEntity="Club\UserBundle\Entity\User")
     * @ORM\JoinTable(name="club_message_message_user",
     *   joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     *
     * @var Club\UserBundle\Entity\User
     */
    private $users;

    /**
     * @ORM\ManytoMany(targetEntity="Club\EventBundle\Entity\Event")
     * @ORM\JoinTable(name="club_message_message_event",
     *   joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")}
     * )
     *
     * @var Club\EventBundle\Entity\Event
     */
    private $events;

    /**
     * @ORM\ManytoMany(targetEntity="Club\UserBundle\Entity\Filter")
     * @ORM\JoinTable(name="club_message_message_filter",
     *   joinColumns={@ORM\JoinColumn(name="message_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="filter_id", referencedColumnName="id")}
     * )
     *
     * @var Club\UserBundle\Entity\Filter
     */
    private $filters;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;

    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
        $this->filters = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set subject
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get subject
     *
     * @return string $subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param text $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return text $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add groups
     *
     * @param Club\UserBundle\Entity\Group $groups
     */
    public function addGroups(\Club\UserBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    }

    /**
     * Get groups
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add users
     *
     * @param Club\UserBundle\Entity\User $users
     */
    public function addUsers(\Club\UserBundle\Entity\User $users)
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

    /**
     * Add events
     *
     * @param Club\EventBundle\Entity\Event $events
     */
    public function addEvents(\Club\EventBundle\Entity\Event $events)
    {
        $this->events[] = $events;
    }

    /**
     * Get events
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add filters
     *
     * @param Club\UserBundle\Entity\Filter $filters
     */
    public function addFilters(\Club\UserBundle\Entity\Filter $filters)
    {
        $this->filters[] = $filters;
    }

    /**
     * Get filters
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFilters()
    {
        return $this->filters;
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
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      if (!$this->getId()) {
        $this->setCreatedAt(new \DateTime());
        $this->setProcessed(0);
      }

      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set processed
     *
     * @param boolean $processed
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;
    }

    /**
     * Get processed
     *
     * @return boolean
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * Set sent_at
     *
     * @param datetime $sentAt
     */
    public function setSentAt($sentAt)
    {
        $this->sent_at = $sentAt;
    }

    /**
     * Get sent_at
     *
     * @return datetime
     */
    public function getSentAt()
    {
        return $this->sent_at;
    }

    /**
     * Set sender_name
     *
     * @param text $senderName
     */
    public function setSenderName($senderName)
    {
        $this->sender_name = $senderName;
    }

    /**
     * Get sender_name
     *
     * @return text
     */
    public function getSenderName()
    {
        return $this->sender_name;
    }

    /**
     * Set sender_address
     *
     * @param text $senderAddress
     */
    public function setSenderAddress($senderAddress)
    {
        $this->sender_address = $senderAddress;
    }

    /**
     * Get sender_address
     *
     * @return text
     */
    public function getSenderAddress()
    {
        return $this->sender_address;
    }

    /**
     * Add message_queue
     *
     * @param Club\MessageBundle\Entity\MessageQueue $messageQueue
     */
    public function addMessageQueue(\Club\MessageBundle\Entity\MessageQueue $messageQueue)
    {
        $this->message_queue[] = $messageQueue;
    }

    /**
     * Get message_queue
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMessageQueue()
    {
        return $this->message_queue;
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
}
