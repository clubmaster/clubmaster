<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\ProductRepository")
 * @ORM\Table(name="club_shop_product")
 */
class Product
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
     * @Assert\NotBlank()
     *
     * @var string $product_name
     */
    protected $product_name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     *
     * @var text $description
     */
    protected $description;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $account_number
     */
    protected $account_number;

    /**
     * @ORM\Column(type="decimal", scale="2")
     * @Assert\NotBlank()
     *
     * @var float $price
     */
    protected $price;

    /**
     * @ORM\Column(type="integer", nullable="true")
     *
     * @var integer $quantity
     */
    protected $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="VariantGroup")
     * @ORM\JoinTable(name="club_shop_product_variantgroup",
     *   joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="variantgroup_id", referencedColumnName="id")}
     * )
     *
     * @var VariantGroup
     */
    protected $variant_groups;

    /**
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="club_shop_category_product",
     *   joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     *
     * @var Club\ShopBundle\Entity\Category
     */
    protected $categories;

    /**
     * @ORM\OneToMany(targetEntity="ProductAttribute", mappedBy="product")
     *
     * @var Club\ShopBundle\Entity\ProductAttribute
     */
    protected $product_attributes;

    /**
     * @ORM\OneToMany(targetEntity="Special", mappedBy="product")
     *
     * @var Club\ShopBundle\Entity\Special
     */
    protected $specials;

    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product_attributes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->type = 'product';
    }

    public function __toString()
    {
      return $this->getProductName();
    }

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
     * Set product_name
     *
     * @param string $productName
     */
    public function setProductName($productName)
    {
        $this->product_name = $productName;
    }

    /**
     * Get product_name
     *
     * @return string $productName
     */
    public function getProductName()
    {
        return $this->product_name;
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
     * Add categories
     *
     * @param Club\ShopBundle\Entity\Category $categories
     */
    public function addCategories(\Club\ShopBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    }

    /**
     * Get categories
     *
     * @return Doctrine\Common\Collections\Collection $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Get product_attributes
     *
     * @return Doctrine\Common\Collections\Collection $product_attributes
     */
    public function getProductAttributes()
    {
        return $this->product_attributes;
    }

    /**
     * Add variant_groups
     *
     * @param Club\ShopBundle\Entity\VariantGroup $variantGroups
     */
    public function addVariantGroups(\Club\ShopBundle\Entity\VariantGroup $variantGroups)
    {
        $this->variant_groups[] = $variantGroups;
    }

    /**
     * Get variant_groups
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getVariantGroups()
    {
        return $this->variant_groups;
    }

    /**
     * Add product_attributes
     *
     * @param Club\ShopBundle\Entity\ProductAttribute $productAttributes
     */
    public function addProductAttributes(\Club\ShopBundle\Entity\ProductAttribute $productAttributes)
    {
        $this->product_attributes[] = $productAttributes;
    }

    /**
     * Add specials
     *
     * @param Club\ShopBundle\Entity\Special $specials
     */
    public function addSpecials(\Club\ShopBundle\Entity\Special $specials)
    {
        $this->specials[] = $specials;
    }

    /**
     * Get specials
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSpecials()
    {
        return $this->specials;
    }

    public function getSpecialPrice()
    {
      foreach ($this->getSpecials() as $special) {
        if ($special->getStartDate()->getTimestamp() < time() && $special->getExpireDate()->getTimestamp() > time())
          return $special->getPrice();
      }
      return $this->getPrice();
    }

    /**
     * Add variant_groups
     *
     * @param Club\ShopBundle\Entity\VariantGroup $variantGroups
     */
    public function addVariantGroup(\Club\ShopBundle\Entity\VariantGroup $variantGroups)
    {
        $this->variant_groups[] = $variantGroups;
    }

    /**
     * Add categories
     *
     * @param Club\ShopBundle\Entity\Category $categories
     */
    public function addCategory(\Club\ShopBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;
    }

    /**
     * Add product_attributes
     *
     * @param Club\ShopBundle\Entity\ProductAttribute $productAttributes
     */
    public function addProductAttribute(\Club\ShopBundle\Entity\ProductAttribute $productAttributes)
    {
        $this->product_attributes[] = $productAttributes;
    }

    /**
     * Add specials
     *
     * @param Club\ShopBundle\Entity\Special $specials
     */
    public function addSpecial(\Club\ShopBundle\Entity\Special $specials)
    {
        $this->specials[] = $specials;
    }

    /**
     * Set account_number
     *
     * @param string $accountNumber
     */
    public function setAccountNumber($accountNumber)
    {
        $this->account_number = $accountNumber;
    }

    /**
     * Get account_number
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    public function getType()
    {
      if (count($this->getProductAttributes()))
        return 'subscription';

      return 'product';
    }
}
