<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\OrderProductVariantRepository")
 * @ORM\Table(name="club_shop_order_product_variant")
 *
 */
class OrderProductVariant
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $variant;
     */
    protected $variant;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $value;
     */
    protected $variant_value;

    /**
     * @ORM\ManyToOne(targetEntity="OrderProduct")
     */
    protected $order_product;

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
    public function setShippingName($shippingName)
    {
        $this->shipping_name = $shippingName;
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
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
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

    /**
     * Set variant
     *
     * @param string $variant
     */
    public function setVariant($variant)
    {
        $this->variant = $variant;
    }

    /**
     * Get variant
     *
     * @return string
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * Set variant_value
     *
     * @param string $variantValue
     */
    public function setVariantValue($variantValue)
    {
        $this->variant_value = $variantValue;
    }

    /**
     * Get variant_value
     *
     * @return string
     */
    public function getVariantValue()
    {
        return $this->variant_value;
    }

    /**
     * Set order_product
     *
     * @param Club\ShopBundle\Entity\OrderProduct $orderProduct
     */
    public function setOrderProduct(\Club\ShopBundle\Entity\OrderProduct $orderProduct)
    {
        $this->order_product = $orderProduct;
    }

    /**
     * Get order_product
     *
     * @return Club\ShopBundle\Entity\OrderProduct
     */
    public function getOrderProduct()
    {
        return $this->order_product;
    }
}
