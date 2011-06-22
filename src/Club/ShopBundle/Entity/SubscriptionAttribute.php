<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\SubscriptionAttribute")
 * @ORM\Table(name="club_shop_subscription_attribute")
 * @ORM\HasLifecycleCallbacks()
 */
class SubscriptionAttribute
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
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Subscription")
     *
     * @var Club\ShopBundle\Entity\Subscription
     */
    private $subscription;

    /**
     * @ORM\ManyToOne(targetEntity="Attribute")
     *
     * @var Club\ShopBundle\Entity\Attribute
     */
    private $attribute;


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
     * Set value
     *
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set subscription
     *
     * @param Club\ShopBundle\Entity\Subscription $subscription
     */
    public function setSubscription(\Club\ShopBundle\Entity\Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get subscription
     *
     * @return Club\ShopBundle\Entity\Subscription $subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Set attribute
     *
     * @param Club\ShopBundle\Entity\Attribute $attribute
     */
    public function setAttribute(\Club\ShopBundle\Entity\Attribute $attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get attribute
     *
     * @return Club\ShopBundle\Entity\Attribute $attribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}