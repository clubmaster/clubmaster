<?php

namespace Club\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club\BookingBundle\Entity\Field
 *
 * @ORM\Table(name="club_booking_field")
 * @ORM\Entity(repositoryClass="Club\BookingBundle\Entity\FieldRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Field
{
    /**
     * @var integer $id
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var integer $position
     *
     * @ORM\Column(type="integer")
     */
    protected $position;

    /**
     * @var text $information
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $information;

    /**
     * @var date $open
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $open;

    /**
     * @var date $close
     *
     * @ORM\Column(type="date", nullable=true)
     */
    protected $close;

    /**
     * @var string $field_layout
     *
     * @ORM\Column(type="text")
     */
    protected $field_layout;

    /**
     * @var boolean $same_layout_every_day
     *
     * @ORM\Column(type="boolean")
     */
    protected $same_layout_every_day;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\Location", inversedBy="fields")
     * @Assert\NotBlank()
     */
    protected $location;

    /**
     * @ORM\OneToMany(targetEntity="Interval", mappedBy="field")
     */
    protected $intervals;

    /**
     * only in use for booking schema
     */
    protected $times;

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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set position
     *
     * @param integer $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
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
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set location
     *
     * @param Club\UserBundle\Entity\Location $location
     */
    public function setLocation(\Club\UserBundle\Entity\Location $location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return Club\UserBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }
    public function __construct()
    {
        $this->intervals = new \Doctrine\Common\Collections\ArrayCollection();
        $this->same_layout_every_day = true;
    }

    /**
     * Add intervals
     *
     * @param Club\BookingBundle\Entity\Interval $intervals
     */
    public function addInterval(\Club\BookingBundle\Entity\Interval $intervals)
    {
        $this->intervals[] = $intervals;
    }

    /**
     * Get intervals
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getIntervals()
    {
        return $this->intervals;
    }

    public function setTimes(array $intervals)
    {
      $this->times = $intervals;
    }

    public function getTimes()
    {
        return $this->times;
    }

    public function toArray()
    {
      $res = array(
        'id' => $this->getId(),
        'name' => $this->getName(),
        'pository' => $this->getPosition(),
        'term' => $this->getInformation()
      );

      if (count($this->getTimes())) {

        $res['intervals'] = array();
        foreach ($this->getTimes() as $interval) {
          $res['intervals'][] = $interval->toArray();
        }
      }

      return $res;
    }

    /**
     * Set information
     *
     * @param text $information
     */
    public function setInformation($information)
    {
        $this->information = $information;
    }

    /**
     * Get information
     *
     * @return text
     */
    public function getInformation()
    {
        return $this->information;
    }

    public function __toString()
    {
      return $this->getName();
    }

    /**
     * Set open
     *
     * @param datetime $open
     */
    public function setOpen($open)
    {
        $this->open = $open;
    }

    /**
     * Get open
     *
     * @return datetime
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set close
     *
     * @param datetime $close
     */
    public function setClose($close)
    {
        $this->close = $close;
    }

    /**
     * Get close
     *
     * @return datetime
     */
    public function getClose()
    {
        return $this->close;
    }

    public function getFormString()
    {
      return $this->getLocation()->getLocationName().', '.$this->getName();
    }

    /**
     * Remove intervals
     *
     * @param Club\BookingBundle\Entity\Interval $intervals
     */
    public function removeInterval(\Club\BookingBundle\Entity\Interval $intervals)
    {
        $this->intervals->removeElement($intervals);
    }

    /**
     * Set same_layout_every_day
     *
     * @param boolean $sameLayoutEveryDay
     * @return Field
     */
    public function setSameLayoutEveryDay($sameLayoutEveryDay)
    {
        $this->same_layout_every_day = $sameLayoutEveryDay;

        return $this;
    }

    /**
     * Get same_layout_every_day
     *
     * @return boolean
     */
    public function getSameLayoutEveryDay()
    {
        return $this->same_layout_every_day;
    }

    /**
     * Set field_layout
     *
     * @param string $fieldLayout
     * @return Field
     */
    public function setFieldLayout($fieldLayout)
    {
        $this->field_layout = $fieldLayout;

        return $this;
    }

    /**
     * Get field_layout
     *
     * @return string
     */
    public function getFieldLayout()
    {
        return $this->field_layout;
    }
}
