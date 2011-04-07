<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\ShopTransactionStatus
 */
class ShopTransactionStatus
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $status_name
     */
    private $status_name;


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
     * @param string $statusName
     */
    public function setStatusName($statusName)
    {
        $this->status_name = $statusName;
    }

    /**
     * Get status_name
     *
     * @return string $statusName
     */
    public function getStatusName()
    {
        return $this->status_name;
    }
}