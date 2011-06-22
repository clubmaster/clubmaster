<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\SubscriptionAttribute")
 * @ORM\Table(name="club_shop_subscription_attribute",
 *    uniqueConstraints={@ORM\UniqueConstraint(name="unique_idx", columns={"subscription_id","attribute_name"})}
 * )
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
     * @ORM\JoinColumn(name="subscription_id", onDelete="cascade")
     *
     * @var Club\ShopBundle\Entity\Subscription
     */
    private $subscription;

    /**
     * @ORM\Column(type="string")
     */
    private $attribute_name;


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
     * Set attribute_name
     *
     * @param string $attributeName
     */
    public function setAttributeName($attributeName)
    {
        $this->attribute_name = $attributeName;
    }

    /**
     * Get attribute_name
     *
     * @return string $attributeName
     */
    public function getAttributeName()
    {
        return $this->attribute_name;
    }
}
