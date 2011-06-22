<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\Subscription")
 * @ORM\Table(name="club_shop_subscription")
 * @ORM\HasLifecycleCallbacks()
 */
class Subscription
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
     * @ORM\Column(type="date")
     *
     * @var datetime $start_date
     */
    private $start_date;

    /**
     * @ORM\Column(type="date")
     *
     * @var datetime $expire_date
     */
    private $expire_date;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer $allowed_pauses
     */
    private $allowed_pauses;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $auto_renewal
     */
    private $auto_renewal;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $is_active
     */
    private $is_active;

    /**
     * @ORM\ManyToOne(targetEntity="Order")
     *
     * @var Club\ShopBundle\Entity\Order
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User", inversedBy="subscriptions")
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="SubscriptionPause", mappedBy="subscription")
     */
    private $subscription_pauses;

    /**
     * @ORM\ManyToMany(targetEntity="Club\UserBundle\Entity\Location")
     * @ORM\JoinTable(name="club_shop_subscription_location",
     *   joinColumns={@ORM\JoinColumn(name="subscription_id", referencedColumnName="id", onDelete="cascade")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="location_id", referencedColumnName="id", onDelete="cascade")}
     * )
     *
     * @var Club\UserBundle\Entity\Location
     */
    private $locations;


    public function __construct()
    {
      $this->locations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set expire_date
     *
     * @param datetime $expireDate
     */
    public function setExpireDate($expireDate)
    {
      $this->expire_date = $expireDate;
    }

    /**
     * Get expire_date
     *
     * @return datetime $expireDate
     */
    public function getExpireDate()
    {
        return $this->expire_date;
    }

    /**
     * Set allowed_pauses
     *
     * @param integer $allowedPauses
     */
    public function setAllowedPauses($allowedPauses)
    {
        $this->allowed_pauses = $allowedPauses;
    }

    /**
     * Get allowed_pauses
     *
     * @return integer $allowedPauses
     */
    public function getAllowedPauses()
    {
        return $this->allowed_pauses;
    }

    /**
     * Set auto_renewal
     *
     * @param boolean $autoRenewal
     */
    public function setAutoRenewal($autoRenewal)
    {
        $this->auto_renewal = $autoRenewal;
    }

    /**
     * Get auto_renewal
     *
     * @return boolean $autoRenewal
     */
    public function getAutoRenewal()
    {
        return $this->auto_renewal;
    }

    public function setUser($user)
    {
      $this->user = $user;
    }

    public function getUser()
    {
      return $this->user;
    }

    public function expire(\DateTime $date)
    {
      $this->setExpireDate($date);
    }

    public function addLocations($location)
    {
      $this->locations[] = $location;
    }

    public function getLocations()
    {
      return $this->locations;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;
    }

    /**
     * Get is_active
     *
     * @return boolean $isActive
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Add subscription_pauses
     *
     * @param Club\ShopBundle\Entity\SubscriptionPause $subscriptionPauses
     */
    public function addSubscriptionPauses(\Club\ShopBundle\Entity\SubscriptionPause $subscriptionPauses)
    {
        $this->subscription_pauses[] = $subscriptionPauses;
    }

    /**
     * Get subscription_pauses
     *
     * @return Doctrine\Common\Collections\Collection $subscriptionPauses
     */
    public function getSubscriptionPauses()
    {
        return $this->subscription_pauses;
    }

    /**
     * @ORM\prePersist
     */
    public function prePersist()
    {
      echo $this->getExpireDate()->format('Y-m-d H:i:s');
    }

    /**
     * Set order
     *
     * @param Club\ShopBundle\Entity\Order $order
     */
    public function setOrder(\Club\ShopBundle\Entity\Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return Club\ShopBundle\Entity\Order $order
     */
    public function getOrder()
    {
        return $this->order;
    }
}
