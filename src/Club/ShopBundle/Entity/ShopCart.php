<?php

namespace Club\ShopBundle\Entity;

/**
 * Club\ShopBundle\Entity\ShopCart
 */
class ShopCart
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $quantity
     */
    private $quantity;

    /**
     * @var string $session
     */
    private $session;

    /**
     * @var Club\ShopBundle\Entity\ShopProduct
     */
    private $product;


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
     * Set quantity
     *
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get quantity
     *
     * @return integer $quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set session
     *
     * @param string $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

    /**
     * Get session
     *
     * @return string $session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set product
     *
     * @param Club\ShopBundle\Entity\ShopProduct $product
     */
    public function setProduct(\Club\ShopBundle\Entity\ShopProduct $product)
    {
        $this->product = $product;
    }

    /**
     * Get product
     *
     * @return Club\ShopBundle\Entity\ShopProduct $product
     */
    public function getProduct()
    {
        return $this->product;
    }
}