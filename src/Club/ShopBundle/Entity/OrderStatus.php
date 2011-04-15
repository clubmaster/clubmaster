<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\OrderStatus")
 * @orm:Table(name="club_shop_order_status")
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
     * @var string $status_name
     */
    private $status_name;

    /**
     * @orm:Column(type="boolean")
     *
     * var boolean $is_complete
     */
    private $is_complete;


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
     * Set status_name
     *
     * @param string $status_name
     */
    public function setStatusName($statusName)
    {
        $this->status_name = $statusName;
    }

    /**
     * Get status_name
     *
     * @return string $status_name
     */
    public function getStatusName()
    {
        return $this->status_name;
    }

    /**
     * Set is_complete
     *
     * @param string $is_complete
     */
    public function setIsComplete($isComplete)
    {
        $this->is_complete = $isComplete;
    }

    /**
     * Get is_complete
     *
     * @return string $is_complete
     */
    public function getIsComplete()
    {
        return $this->is_complete;
    }

}
