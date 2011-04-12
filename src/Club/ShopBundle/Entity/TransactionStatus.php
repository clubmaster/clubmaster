<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\TransactionStatus")
 * @orm:Table(name="club_shop_transaction_status")
 */
class TransactionStatus
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
