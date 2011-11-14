<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\SubscriptionTicketAttribute")
 * @ORM\Table(name="club_shop_subscription_ticket_attribute")
 * @ORM\HasLifecycleCallbacks()
 */
class SubscriptionTicketAttribute
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
     * @var string $attribute
     */
    private $attribute;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $value
     */
    private $value;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $updated_at
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="SubscriptionTicket")
     *
     * @var Club\ShopBundle\Entity\SubscriptionTicket
     */
    private $subscription_ticket;


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
     * Set attribute
     *
     * @param string $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get attribute
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
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
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
    public function __construct()
    {
        $this->subscription_ticket = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set subscription_ticket
     *
     * @param Club\ShopBundle\Entity\SubscriptionTicket $subscriptionTicket
     */
    public function setSubscriptionTicket(\Club\ShopBundle\Entity\SubscriptionTicket $subscriptionTicket)
    {
        $this->subscription_ticket = $subscriptionTicket;
    }
}
