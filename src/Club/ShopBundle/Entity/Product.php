<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\Product")
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
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $product_name
     */
    private $product_name;

    /**
     * @ORM\Column(type="text")
     *
     * @var text $description
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", scale="2")
     *
     * @var float $price
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable="true")
     *
     * @var integer $quantity
     */
    private $quantity;

    /**
     * @ORM\ManyToMany(targetEntity="VariantGroup")
     *
     * @var VariantGroup
     */
    private $variant_groups;

    /**
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="club_shop_category_product",
     *   joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     *
     * @var Club\ShopBundle\Entity\Category
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="Vat")
     *
     * @var Club\ShopBundle\Entity\Vat
     */
    private $vat;

    /**
     * @ORM\ManyToOne(targetEntity="Club\AccountBundle\Entity\Account")
     *
     * @var Club\AccountBundle\Entity\Account
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity="ProductAttribute", mappedBy="product")
     *
     * @var Club\ShopBundle\Entity\ProductAttribute
     */
    private $product_attributes;

    /**
     * @ORM\OneToMany(targetEntity="Special", mappedBy="product")
     *
     * @var Club\ShopBundle\Entity\Special
     */
    private $specials;

    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product_attributes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set vat
     *
     * @param float $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * Get vat
     *
     * @return float $vat
     */
    public function getVat()
    {
        return $this->vat;
    }

    public function getVatPrice()
    {
      return sprintf("%.2f",$this->getPrice()*(1+$this->getVat()->getRate()/100));
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
     * Set account
     *
     * @param Club\AccountBundle\Entity\Account $account
     */
    public function setAccount(\Club\AccountBundle\Entity\Account $account)
    {
        $this->account = $account;
    }

    /**
     * Get account
     *
     * @return Club\AccountBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
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

    public function getSpecialVatPrice()
    {
      return sprintf("%.2f",$this->getSpecialPrice()*(1+$this->getVat()->getRate()/100));
    }
}
