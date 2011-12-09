<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\OrderProductAttribute")
 * @ORM\Table(name="club_shop_order_product_attribute")
 *
 */
class OrderProductAttribute
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
     * @var string $attribute_name
     */
    protected $attribute_name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $value
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="OrderProduct")
     * @ORM\JoinColumn(name="order_product_id", onDelete="cascade")
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
