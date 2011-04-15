<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\OrderProductAttribute")
 * @orm:Table(name="club_shop_order_product_attribute")
 *
 */
class OrderProductAttribute
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
     * @var string $attribute_name
     */
    private $attribute_name;

    /**
     * @orm:Column(type="string")
     *
     * @var string $value
     */
    private $value;

    /**
     * @orm:ManyToOne(targetEntity="OrderProduct")
     */
    private $order_product;

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
     * Set shipping_name
     *
     * @param string $shippingName
     */
    public function setOrderProduct($orderProduct)
    {
        $this->order_product = $orderProduct;
    }

    /**
     * Get shipping_name
     *
     * @return string $shippingName
     */
    public function getShippingName()
    {
        return $this->shipping_name;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setAttributeName($attributeName)
    {
        $this->attribute_name = $attributeName;
    }

    /**
     * Get description
     *
     * @return text $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get price
     *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }
}
