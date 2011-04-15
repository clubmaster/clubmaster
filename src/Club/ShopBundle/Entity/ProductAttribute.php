<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\ProductAttribute")
 * @orm:Table(name="club_shop_product_attribute")
 *
 */
class ProductAttribute
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
     * @var string $value
     */
    private $value;

    /**
     * @orm:ManyToOne(targetEntity="Product")
     */
    private $product;

    /**
     * @orm:ManyToOne(targetEntity="Attribute")
     */
    private $attribute;

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
     * Set value
     *
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return float $value
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }
}
