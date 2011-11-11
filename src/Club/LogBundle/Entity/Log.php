<?php

namespace Club\LogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\LogBundle\Entity\LogRepository")
 * @ORM\Table(name="club_log_log")
 * @ORM\HasLifecycleCallbacks()
 */
class Log
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
     * @var string $event
     */
    private $event;

    /**
     * @ORM\Column(type="text")
     *
     * @var string $log
     */
    private $log;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice({ "security", "general", "shop" })
     *
     * @var string $log_type
     */
    private $log_type;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice({ "debug", "informational", "warning", "critical" })
     */
    private $severity;

    /**
     * @ORM\Column(type="boolean")
     */
    private $new;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $created_at
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     */
    private $user;

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
     * Set event
     *
     * @param string $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * Get event
     *
     * @return string $event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set log
     *
     * @param text $log
     */
    public function setLog($log)
    {
        $this->log = $log;
    }

    /**
     * Get log
     *
     * @return text $log
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set log_type
     *
     * @param string $logType
     */
    public function setLogType($logType)
    {
        $this->log_type = $logType;
    }

    /**
     * Get log_type
     *
     * @return string $logType
     */
    public function getLogType()
    {
        return $this->log_type;
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
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setNew(1);
    }

    /**
     * Set severity
     *
     * @param string $severity
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;
    }

    /**
     * Get severity
     *
     * @return string $severity
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Set new
     *
     * @param boolean $new
     */
    public function setNew($new)
    {
        $this->new = $new;
    }

    /**
     * Get new
     *
     * @return boolean
     */
    public function getNew()
    {
        return $this->new;
    }
}
