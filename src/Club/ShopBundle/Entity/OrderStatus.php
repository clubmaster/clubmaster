<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\OrderStatus")
 * @orm:Table(name="club_shop_order_statu")
 */
class OrderStatus
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
     * @orm:Column(type="string")
     *
     * @var string $status
     */
    private $status;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $open
     */
    private $open;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $complete
     */
    private $complete;


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
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set open
     *
     * @param boolean $open
     */
    public function setOpen($open)
    {
        $this->open = $open;
    }

    /**
     * Get open
     *
     * @return boolean $open
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set complete
     *
     * @param boolean $complete
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
    }

    /**
     * Get complete
     *
     * @return boolean $complete
     */
    public function getComplete()
    {
        return $this->complete;
    }
}
