<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\VariantGroupRepository")
 * @ORM\Table(name="club_shop_variant_group")
 *
 */
class VariantGroup
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
     * @var string $variant_group_name
     */
    protected $variant_group_name;

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
     * Set variant_group_name
     *
     * @param string $variantGroupName
     */
    public function setVariantGroupName($variantGroupName)
    {
        $this->variant_group_name = $variantGroupName;
    }

    /**
     * Get variant_group_name
     *
     * @return string 
     */
    public function getVariantGroupName()
    {
        return $this->variant_group_name;
    }
}