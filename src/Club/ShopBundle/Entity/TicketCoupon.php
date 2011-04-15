<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\TicketCoupon")
 * @orm:Table(name="club_shop_ticket_coupon")
 * @orm:HasLifecycleCallbacks()
 */
class TicketCoupon
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @orm:Column(type="integer")
     *
     * @var integer $ticket
     */
    private $ticket;

    /**
     * @orm:Column(type="date")
     *
     * @var datetime $start_date
     */
    private $start_date;

    /**
     * @orm:Column(type="date")
     *
     * @var datetime $expire_date
     */
    private $expire_date;

    /**
     * @orm:ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;


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
     * Set ticket
     *
     * @param integer $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get ticket
     *
     * @return integer $ticket
     */
    public function getTicket()
    {
        return $this->ticket;
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
     * @orm:prePersist()
     */
    public function prePersist()
    {
      $this->setStartDate(new \DateTime());
      $this->setExpireDate(new \DateTime());
    }
}
