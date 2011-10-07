<?php

namespace Club\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\TaskBundle\Repository\Task")
 * @ORM\Table(name="club_task_task")
 * @ORM\HasLifecycleCallbacks()
 */
class Task
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
     * @var integer $task_name
     */
    private $task_name;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $enabled
     */
    private $enabled;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $locked
     */
    private $locked;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $event
     */
    private $event;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $method
     */
    private $method;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     *
     * @var date $last_run_at
     */
    private $last_run_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var date $next_run_at
     */
    private $next_run_at;

    /**
     * @ORM\Column(type="string")
     *
     * @var date $task_interval
     */
    private $task_interval;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var date $created_at
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var date $updated_at
     */
    private $updated_at;

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
     * Set task_name
     *
     * @param string $taskName
     */
    public function setTaskName($taskName)
    {
        $this->task_name = $taskName;
    }

    /**
     * Get task_name
     *
     * @return string $taskName
     */
    public function getTaskName()
    {
        return $this->task_name;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    /**
     * Get locked
     *
     * @return boolean $locked
     */
    public function getLocked()
    {
        return $this->locked;
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
     * @return datetime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set last_run_at
     *
     * @param datetime $lastRunAt
     */
    public function setLastRunAt($lastRunAt)
    {
        $this->last_run_at = $lastRunAt;
    }

    /**
     * Get last_run_at
     *
     * @return datetime $lastRunAte
     */
    public function getLastRunAt()
    {
        return $this->last_run_at;
    }

    /**
     * Set next_run_at
     *
     * @param datetime $nextRunAt
     */
    public function setNextRunAt($nextRunAt)
    {
        $this->next_run_at = $nextRunAt;
    }

    /**
     * Get next_run_at
     *
     * @return datetime $nextRunAt
     */
    public function getNextRunAt()
    {
        return $this->next_run_at;
    }


    /**
     * Set task_interval
     *
     * @param string $taskInterval
     */
    public function setTaskInterval($taskInterval)
    {
        $this->task_interval = $taskInterval;
    }

    /**
     * Get task_interval
     *
     * @return string $taskInterval
     */
    public function getTaskInterval()
    {
        return $this->task_interval;
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
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\preUpdate()
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set method
     *
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function getTaskIntervalPretty()
    {
      $date1 = new \Club\UserBundle\Helper\DateTime();
      $date2 = new \Club\UserBundle\Helper\DateTime();
      $i = new \DateInterval('P'.$this->getTaskInterval());
      $date2->add($i);

      return $date2->formatDateDiff($date1, $date2);
    }
}
