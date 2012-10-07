<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\SpecialRepository")
 * @ORM\Table(name="club_shop_special")
 * @ORM\HasLifecycleCallbacks()
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
    protected $id;

    /**
     * @ORM\Column(type="date")
     *
     * @var datetime $start_date
     */
    protected $start_date;

    /**
     * @ORM\Column(type="date")
     *
     * @var datetime $expire_date
     */
    protected $expire_date;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank()
     *
     * @var float $price
     */
    protected $price;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $updated_at
     */
    protected $updated_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var datetime $created_at
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="specials")
     *
     * @var Club\ShopBundle\Entity\Product
     */
    protected $product;

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

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }
}
