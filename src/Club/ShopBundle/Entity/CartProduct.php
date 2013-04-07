<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\CartProductRepository")
 * @ORM\Table(name="club_shop_cart_product")
 */
class CartProduct
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
     * @var string $product_name
     */
    protected $product_name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     *
     * @var float $price
     */
    protected $price;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer $quantity
     */
    protected $quantity;

    /**
     * @ORM\Column(type="string")
     *
     * @var integer $type
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="Club\ShopBundle\Entity\Product")
     *
     * @var Club\UserBundle\Entity\Product
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Club\ShopBundle\Entity\Cart", inversedBy="cart_products")
     * @ORM\JoinColumn(name="cart_id", referencedColumnName="id", onDelete="cascade")
     *
     * @var Club\UserBundle\Entity\Cart
     */
    protected $cart;

    /**
     * @ORM\OneToMany(targetEntity="Club\ShopBundle\Entity\CartProductAttribute", mappedBy="cart_product", cascade={"persist","remove"})
     */
    protected $cart_product_attributes;

    public function __construct()
    {
        $this->quantity = 1;
        $this->cart_product_attributes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * *
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
     * Set cart
     *
     * @param string $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * Get cart
     *
     * @return string $cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    public function setProduct($product)
    {
      $this->product = $product;
    }

    public function getProduct()
    {
      return $this->product;
    }

    public function addCartProductAttribute(\Club\ShopBundle\Entity\CartProductAttribute $cartProductAttribute)
    {
      $this->cart_product_attributes[] = $cartProductAttribute;
    }

    public function getCartProductAttributes()
    {
        return $this->cart_product_attributes;
    }

    public function getProductAttributes()
    {
        return $this->cart_product_attributes;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add cart_product_attributes
     *
     * @param Club\ShopBundle\Entity\CartProductAttribute $cartProductAttributes
     */
    public function addCartProductAttributes(\Club\ShopBundle\Entity\CartProductAttribute $cartProductAttributes)
    {
        $this->cart_product_attributes[] = $cartProductAttributes;
    }

    public function getSummary()
    {
      return $this->getPrice()*$this->getQuantity();
    }
}
