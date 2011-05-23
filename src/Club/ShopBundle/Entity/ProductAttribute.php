<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\ProductAttribute")
 * @ORM\Table(name="club_shop_product_attribute")
 *
 */
class ProductAttribute
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $value
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Attribute")
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
