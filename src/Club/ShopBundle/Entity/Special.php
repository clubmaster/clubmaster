<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\Special")
 * @ORM\Table(name="club_shop_special")
 *
 */
class Special
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
     * @ORM\Column(type="date")
     *
     * @var datetime $start_date
     */
    private $start_date;

    /**
     * @ORM\Column(type="date")
     *
     * @var datetime $expire_date
     */
    private $expire_date;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var float $price
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     *
     * @var Club\ShopBundle\Entity\Product
     */
    private $product;


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
     * Set start_date
     *
     * @param datetime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->start_date = $startDate;
    }

    /**
     * Get start_date
     *
     * @return datetime $startDate
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set expire_date
     *
     * @param datetime $expireDate
     */
    public function setExpireDate($expireDate)
    {
        $this->expire_date = $expireDate;
    }

    /**
     * Get expire_date
     *
     * @return datetime $expireDate
     */
    public function getExpireDate()
    {
        return $this->expire_date;
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
     * Set product
     *
     * @param Club\ShopBundle\Entity\Product $Product
     */
    public function setProduct(\Club\ShopBundle\Entity\Product $Product)
    {
        $this->product = $Product;
    }

    /**
     * Get product
     *
     * @return Club\ShopBundle\Entity\Product $Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
