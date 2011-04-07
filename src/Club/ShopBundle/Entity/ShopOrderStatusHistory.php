<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\ShopOrderStatusHistory
 */
class ShopOrderStatusHistory
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var text $note
     */
    private $note;

    /**
     * @var Club\ShopBundle\Entity\ShopOrderStatus
     */
    private $shop_order_status;


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
     * Set note
     *
     * @param text $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * Get note
     *
     * @return text $note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set shop_order_status
     *
     * @param Club\ShopBundle\Entity\ShopOrderStatus $shopOrderStatus
     */
    public function setShopOrderStatus(\Club\ShopBundle\Entity\ShopOrderStatus $shopOrderStatus)
    {
        $this->shop_order_status = $shopOrderStatus;
    }

    /**
     * Get shop_order_status
     *
     * @return Club\ShopBundle\Entity\ShopOrderStatus $shopOrderStatus
     */
    public function getShopOrderStatus()
    {
        return $this->shop_order_status;
    }
}