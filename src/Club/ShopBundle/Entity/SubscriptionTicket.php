<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\SubscriptionTicket")
 * @ORM\Table(name="club_shop_subscription_ticket")
 * @ORM\HasLifecycleCallbacks()
 */
class SubscriptionTicket
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
     * @ORM\Column(type="integer")
     *
     * @var datetime $tickets
     */
    private $tickets;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $note
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Subscription")
     *
     * @var Club\ShopBundle\Entity\Subscription
     */
    private $subscription;

    /**
     * @ORM\OneToMany(targetEntity="SubscriptionTicketAttribute", mappedBy="subscription_ticket")
     *
     * @var Club\ShopBundle\Entity\SubscriptionTicketAttribute
     */
    private $subscription_ticket_attribute;


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
     * Set tickets
     *
     * @param int $tickets
     */
    public function setTickets($tickets)
    {
        $this->tickets = $tickets;
    }

    /**
     * Get tickets
     *
     * @return int
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set created_at
     *
     * @param date $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return date
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }

    /**
     * Set note
     *
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }
    public function __construct()
    {
        $this->subscription_ticket_attribute = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add subscription_ticket_attribute
     *
     * @param Club\ShopBundle\Entity\SubscriptionTicketAttribute $subscriptionTicketAttribute
     */
    public function addSubscriptionTicketAttribute(\Club\ShopBundle\Entity\SubscriptionTicketAttribute $subscriptionTicketAttribute)
    {
        $this->subscription_ticket_attribute[] = $subscriptionTicketAttribute;
    }

    /**
     * Get subscription_ticket_attribute
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSubscriptionTicketAttribute()
    {
        return $this->subscription_ticket_attribute;
    }
}