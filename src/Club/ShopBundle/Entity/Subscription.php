<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\SubscriptionRepository")
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
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice({ "subscription", "ticket" })
     */
    protected $type;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $start_date
     */
    protected $start_date;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     *
     * @var datetime $expire_date
     */
    protected $expire_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $updated_at
     */
    protected $updated_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $created_at
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="OrderProduct")
     *
     * @var Club\ShopBundle\Entity\OrderProduct
     */
    protected $order_product;

    /**
     * @ORM\ManyToOne(targetEntity="Order")
     *
     * @var Club\ShopBundle\Entity\Order
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User", inversedBy="subscriptions")
     *
     * @var Club\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="SubscriptionAttribute", mappedBy="subscription")
     */
    protected $subscription_attributes;

    /**
     * @ORM\OneToMany(targetEntity="SubscriptionTicket", mappedBy="subscription")
     */
    protected $subscription_ticket;

    /**
     * @ORM\OneToMany(targetEntity="SubscriptionPause", mappedBy="subscription")
     */
    protected $subscription_pauses;

    /**
     * @ORM\ManyToMany(targetEntity="Club\UserBundle\Entity\Location")
     * @ORM\JoinTable(name="club_shop_subscription_location",
     *   joinColumns={@ORM\JoinColumn(name="subscription_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="location_id", referencedColumnName="id")}
     * )
     *
     * @var Club\UserBundle\Entity\Location
     */
    protected $location;


    public function __construct()
    {
        $this->subscription_pauses = new \Doctrine\Common\Collections\ArrayCollection();
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
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set order product
     *
     * @param Club\ShopBundle\Entity\OrderProduct $order_product
     */
    public function setOrderProduct(\Club\ShopBundle\Entity\OrderProduct $order_product)
    {
        $this->order_product = $order_product;
    }

    /**
     * Get order product
     *
     * @return Club\ShopBundle\Entity\OrderProduct
     */
    public function getOrderProduct()
    {
        return $this->order_product;
    }

    /**
     * Get location
     *
     * @return Doctrine\Common\Collections\Collection $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add product
     *
     * @param Club\ShopBundle\Entity\Product $product
     */
    public function addProduct(\Club\ShopBundle\Entity\Product $product)
    {
        $this->product[] = $product;
    }

    public function isExpired()
    {
      if ($this->getExpireDate() == null)
        return false;

      if ($this->getExpireDate()->getTimestamp() < time())
        return true;

      return false;
    }

    public function isPaused()
    {
      foreach ($this->getSubscriptionPauses() as $pause) {
        if ($pause->getExpireDate() == null)
          return true;
      }

      return false;
    }

    /**
     * Add subscription_attributes
     *
     * @param Club\ShopBundle\Entity\SubscriptionAttribute $subscriptionAttributes
     */
    public function addSubscriptionAttribute(\Club\ShopBundle\Entity\SubscriptionAttribute $subscriptionAttributes)
    {
        $this->subscription_attributes[] = $subscriptionAttributes;
    }

    /**
     * Add subscription_pauses
     *
     * @param Club\ShopBundle\Entity\SubscriptionPause $subscriptionPauses
     */
    public function addSubscriptionPause(\Club\ShopBundle\Entity\SubscriptionPause $subscriptionPauses)
    {
        $this->subscription_pauses[] = $subscriptionPauses;
    }

    /**
     * Add location
     *
     * @param Club\UserBundle\Entity\Location $location
     */
    public function addLocation(\Club\UserBundle\Entity\Location $location)
    {
        $this->location[] = $location;
    }

    public function getActive()
    {
      if ($this->isExpired())
        return false;

      return true;
    }

    public function hasAttribute($key)
    {
      foreach ($this->getSubscriptionAttributes() as $attr) {
        if ($attr->getAttributeName() == $key)
          return true;
      }

      return false;
    }

    public function getAttribute($key)
    {
      foreach ($this->getSubscriptionAttributes() as $attr) {
        if ($attr->getAttributeName() == $key)
          return $attr;
      }

      return false;
    }

    public function getStartTickets()
    {
      return $this->getAttribute('ticket')->getValue();
    }

    public function getStartPauses()
    {
      return $this->getAttribute('allowed_pauses')->getValue();
    }

    /**
     * Add subscription_ticket
     *
     * @param Club\ShopBundle\Entity\SubscriptionTicket $subscriptionTicket
     */
    public function addSubscriptionTicket(\Club\ShopBundle\Entity\SubscriptionTicket $subscriptionTicket)
    {
        $this->subscription_ticket[] = $subscriptionTicket;
    }

    /**
     * Get subscription_ticket
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSubscriptionTicket()
    {
        return $this->subscription_ticket;
    }
}
