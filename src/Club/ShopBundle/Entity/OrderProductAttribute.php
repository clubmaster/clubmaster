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

    public function getAttributeName()
    {
        return $this->attribute_name;
    }

    public function setAttributeName($attributeName)
    {
        $this->attribute_name = $attributeName;
    }

    public function getValue()
    {
      return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}
