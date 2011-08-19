<?php

namespace Club\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\MessageBundle\Repository\MessageQueue")
 * @ORM\Table(name="club_message_message_queue")
 * @ORM\HasLifecycleCallbacks()
 */
class MessageQueue
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
     * @ORM\Column(type="string", nullable="true")
     */
    private $error_message;

    /**
     * @ORM\Column(type="boolean")
     */
    private $processed;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string")
     */
    private $recipient;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Message")
     *
     * @var Club\MessageBundle\Entity\Message
     */
    private $message;

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
     * Set error_message
     *
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->error_message = $errorMessage;
    }

    /**
     * Get error_message
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->error_message;
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
     * Set user
     *
     * @param \Club\UserBundle\Entity\User $user
     */
    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return \Club\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set message
     *
     * @param Club\MessageBundle\Entity\Message $message
     */
    public function setMessage(\Club\MessageBundle\Entity\Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return Club\MessageBundle\Entity\Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      if (!$this->getId())
        $this->setCreatedAt(new \DateTime());

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
     * Set recipient
     *
     * @param string $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Get recipient
     *
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }
}
