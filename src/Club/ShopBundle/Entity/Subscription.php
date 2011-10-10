<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\Subscription")
 * @ORM\Table(name="club_shop_subscription",
 *   indexes={@ORM\index(
 *     name="active_idx",
 *     columns={"active"}
 *   )}
 * )
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
     * @var boolean $active
     */
    private $active;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $start_date
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     *
     * @var datetime $expire_date
     */
    private $expire_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $updated_at
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="OrderProduct")
     *
     * @var Club\ShopBundle\Entity\OrderProduct
     */
    private $order_product;

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
     *   joinColumns={@ORM\JoinColumn(name="subscription_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="location_id", referencedColumnName="id")}
     * )
     *
     * @var Club\UserBundle\Entity\Location
     */
    private $location;


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
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean $active
     */
    public function getActive()
    {
        return $this->active;
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

      if (!$this->getActive() && $this->getExpireDate()->getTimestamp() < time())
        return true;

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
}
