<?php

namespace Club\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\EventBundle\Entity\EventRepository")
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
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string $event_name
     */
    protected $event_name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     *
     * @var string $description
     */
    protected $description;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank()
     *
     * @var float $price
     */
    protected $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var string $max_attends
     */
    protected $max_attends;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $start_date
     */
    protected $start_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $stop_date
     */
    protected $stop_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $last_subscribe
     */
    protected $last_subscribe;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string $street
     */
    protected $street;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string $postal_code
     */
    protected $postal_code;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string $city
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string $country
     */
    protected $country;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var string $public
     */
    protected $public;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $created_at
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $updated_at
     */
    protected $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="Attend", mappedBy="event", cascade={"persist"})
     */
    protected $attends;


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

    public function isAttending(\Club\UserBundle\Entity\User $user)
    {
      foreach ($this->getAttends() as $attend) {
        if ($attend->getUser()->getId() == $user->getId()) return true;
      }

      return false;
    }

    public function __construct()
    {
        $this->price = 0;
        $this->setPublic(true);
        $this->setStartDate(new \DateTime(date('Y-m-d 18:00:00')));
        $this->setStopDate(new \DateTime(date('Y-m-d 22:00:00')));
        $this->setLastSubscribe(new \DateTime(date('Y-m-d 00:00:00')));

        $month = new \DateInterval('P1M');
        $week = new \DateInterval('P1W');

        $this->getStartDate()->add($month);
        $this->getStopDate()->add($month);
        $this->getLastSubscribe()->add($month)->sub($week);

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
      $res = array(
        'id' => $this->getId(),
        'event_name' => $this->getEventName(),
        'description' => $this->getDescription(),
        'max_attends' => $this->getMaxAttends(),
        'attends' => array(),
        'start_date' => $this->getStartDate()->format('c'),
        'stop_date' => $this->getStopDate()->format('c'),
        'last_subscribe' => $this->getLastSubscribe()->format('c'),
        'created_at' => $this->getCreatedAt()->format('c')
      );

      foreach ($this->getAttends() as $attend) {
        $res['attends'][] = array(
          'user_id' => $attend->getUser()->getId()
        );
      }

      return $res;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Event
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set postal_code
     *
     * @param string $postalCode
     * @return Event
     */
    public function setPostalCode($postalCode)
    {
        $this->postal_code = $postalCode;

        return $this;
    }

    /**
     * Get postal_code
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Event
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Event
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add attends
     *
     * @param Club\EventBundle\Entity\Attend $attends
     * @return Event
     */
    public function addAttend(\Club\EventBundle\Entity\Attend $attends)
    {
        $this->attends[] = $attends;

        return $this;
    }

    /**
     * Remove attends
     *
     * @param Club\EventBundle\Entity\Attend $attends
     */
    public function removeAttend(\Club\EventBundle\Entity\Attend $attends)
    {
        $this->attends->removeElement($attends);
    }

    /**
     * Set public
     *
     * @param boolean $public
     * @return Event
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return boolean
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set last_subscribe
     *
     * @param \DateTime $lastSubscribe
     * @return Event
     */
    public function setLastSubscribe($lastSubscribe)
    {
        $this->last_subscribe = $lastSubscribe;

        return $this;
    }

    /**
     * Get last_subscribe
     *
     * @return \DateTime
     */
    public function getLastSubscribe()
    {
        return $this->last_subscribe;
    }

    public function isOpen()
    {
        if ($this->getLastSubscribe() > new \DateTime()) return true;

        return false;
    }

    public function getLocationString()
    {
        $res = '';

        if ($this->getStreet()) $res .= $this->getStreet().', ';

        if (strlen($this->getPostalCode()) || strlen($this->getCity())) {
            if ($this->getPostalCode()) $res .= $this->getPostalCode().' ';
            if ($this->getCity()) $res .= $this->getCity();

            $res .= ', ';
        }

        if ($this->getCountry()) $res .= $this->getCountry();

        return preg_replace("/, $/", "", $res);
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Event
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}
