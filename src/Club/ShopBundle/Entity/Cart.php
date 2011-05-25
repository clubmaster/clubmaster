<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\Cart")
 * @ORM\Table(name="club_shop_cart")
 * @ORM\HasLifecycleCallbacks
 */
class Cart
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
     * @ORM\Column(type="decimal")
     *
     * @var string $price
     */
    protected $price;

    /**
     * @ORM\ManyToOne(targetEntity="Shipping")
     * @Assert\NotBlank()
     *
     * @var Club\ShopBundle\Entity\Shipping
     */
    protected $shipping;

    /**
     * @ORM\ManyToOne(targetEntity="PaymentMethod")
     * @Assert\Notblank()
     * @Assert\NotBlank(groups={"PaymentMethod"})
     *
     * @var Club\ShopBundle\Entity\PaymentMethod
     */
    protected $payment_method;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     * @Assert\NotBlank()
     *
     * @var Club\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="Club\ShopBundle\Entity\CartProduct", mappedBy="cart", cascade={"persist"})
     *
     * @var Club\ShopBundle\Entity\CartProduct
     */
    protected $cart_products;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    public function __construct() {
      $this->cart_products = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function setPrice($price)
    {
      $this->price = $price;
    }

    public function getPrice()
    {
      return $this->price;
    }

    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add cartProduct
     *
     * @param Club\ShopBundle\Entity\CartProduct $cart_products
     */
    public function addCartProduct(\Club\ShopBundle\Entity\CartProduct $cartProduct)
    {
        $this->cart_products[] = $cartProduct;
    }

    /**
     * Get cartProduct
     *
     * @return Doctrine\Common\Collections\Collection $cart_products
     */
    public function getCartProducts()
    {
        return $this->cart_products;
    }

    public function setCreatedAt($createdAt)
    {
      $this->created_at = $createdAt;
    }

    public function getCreatedAt()
    {
      return $this->created_at;
    }

    public function setShipping(\Club\ShopBundle\Entity\Shipping $shipping)
    {
        $this->shipping = $shipping;
    }

    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set payment_method
     *
     * @param Club\ShopBundle\Entity\PaymentMethod $PaymentMethod
     */
    public function setPaymentMethod(\Club\ShopBundle\Entity\PaymentMethod $PaymentMethod)
    {
        $this->payment_method = $PaymentMethod;
    }

    /**
     * Get payment_method
     *
     * @return Club\ShopBundle\Entity\PaymentMethod $PaymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }
}
