<?php

namespace Club\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\EventBundle\Repository\Event")
 * @ORM\Table(name="club_event_event")
 * @ORM\HasLifecycleCallbacks()
 */
class Event
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
     * @Assert\NotBlank()
     *
     * @var string $event_name
     */
    private $event_name;

    /**
     * @ORM\Column(type="text")
     *
     * @var string $description
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", scale="2", nullable="true")
     *
     * @var string $price
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable="true")
     *
     * @var string $max_attends
     */
    private $max_attends;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $start_date
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $stop_date
     */
    private $stop_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $created_at
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $updated_at
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="Attend", mappedBy="event")
     */
    private $attends;


    public function __toString()
    {
      return $this->getEventName();
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
     * Set event_name
     *
     * @param string $eventName
     */
    public function setEventName($eventName)
    {
        $this->event_name = $eventName;
    }

    /**
     * Get event_name
     *
     * @return string $eventName
     */
    public function getEventName()
    {
        return $this->event_name;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param decimal $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Get price
     *
     * @return decimal $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set max_attends
     *
     * @param integer $maxAttends
     */
    public function setMaxAttends($maxAttends)
    {
        $this->max_attends = $maxAttends;
    }

    /**
     * Get max_attends
     *
     * @return integer $maxAttends
     */
    public function getMaxAttends()
    {
        return $this->max_attends;
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
     * @return datetime $startDate
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
     * @return datetime $stopDate
     */
    public function getStopDate()
    {
        return $this->stop_date;
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
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      if (!$this->getId()) {
        $this->setCreatedAt(new \DateTime());
      }
      $this->setUpdatedAt(new \DateTime());
    }

    public function isAttending(\Club\UserBundle\Entity\User $user)
    {
      foreach ($this->getAttends() as $attend) {
        if ($attend->getUser()->getId() == $user->getId()) return true;
      }

      return false;
    }

    public function __construct()
    {
        $this->attends = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add attends
     *
     * @param Club\EventBundle\Entity\Attend $attends
     */
    public function addAttends(\Club\EventBundle\Entity\Attend $attends)
    {
        $this->attends[] = $attends;
    }

    /**
     * Get attends
     *
     * @return Doctrine\Common\Collections\Collection $attends
     */
    public function getAttends()
    {
        return $this->attends;
    }

    public function toArray()
    {
      return array(
        'id' => $this->getId(),
        'event_name' => $this->getEventName(),
        'description' => $this->getDescription(),
        'price' => $this->getPrice(),
        'max_attends' => $this->getMaxAttends(),
        'start_date' => $this->getStartDate(),
        'stop_date' => $this->getStopDate(),
        'created_at' => $this->getCreatedAt()
      );
    }
}
