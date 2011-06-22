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
     * @ORM\Column(type="string")
     * @Assert\Choice({ "subscription", "ticket_coupon" })
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $is_active
     */
    private $is_active;

    /**
     * @ORM\Column(type="date")
     *
     * @var datetime $start_date
     */
    private $start_date;

    /**
     * @ORM\Column(type="date", nullable="true")
     *
     * @var datetime $expire_date
     */
    private $expire_date;

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
     * @ORM\OneToMany(targetEntity="SubscriptionAttribute", mappedBy="subscription")
     */
    private $subscription_attributes;

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
        $this->subscription_pauses = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add locations
     *
     * @param Club\UserBundle\Entity\Location $locations
     */
    public function addLocations(\Club\UserBundle\Entity\Location $locations)
    {
        $this->locations[] = $locations;
    }

    /**
     * Get locations
     *
     * @return Doctrine\Common\Collections\Collection $locations
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Set start_date
     *
     * @param date $startDate
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
    }

    /**
     * Get start_date
     *
     * @return date $startDate
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set expire_date
     *
     * @param date $expireDate
     */
    public function setExpireDate($expireDate)
    {
        $this->expire_date = $expireDate;
    }

    /**
     * Get expire_date
     *
     * @return date $expireDate
     */
    public function getExpireDate()
    {
        return $this->expire_date;
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
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add subscription_attributes
     *
     * @param Club\ShopBundle\Entity\SubscriptionAttribute $subscriptionAttributes
     */
    public function addSubscriptionAttributes(\Club\ShopBundle\Entity\SubscriptionAttribute $subscriptionAttributes)
    {
        $this->subscription_attributes[] = $subscriptionAttributes;
    }

    /**
     * Get subscription_attributes
     *
     * @return Doctrine\Common\Collections\Collection $subscriptionAttributes
     */
    public function getSubscriptionAttributes()
    {
        return $this->subscription_attributes;
    }
}
