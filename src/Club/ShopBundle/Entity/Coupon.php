<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\Coupon")
 * @ORM\Table(name="club_shop_coupon")
 * @ORM\HasLifecycleCallbacks
 *
 */
class Coupon
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
     * @ORM\Column(type="string", unique="true")
     *
     * @var string $coupon_key
     */
    private $coupon_key;

    /**
     * @ORM\Column(type="decimal", scale="2")
     *
     * @var float $value
     */
    private $value;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_usage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expire_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;


    public function __construct()
    {
      $this->setCouponKey(uniqid());
      $this->setExpireAt(new \DateTime("+1 month"));
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set coupon_key
     *
     * @param string $couponKey
     */
    public function setCouponKey($couponKey)
    {
        $this->coupon_key = $couponKey;
    }

    /**
     * Get coupon_key
     *
     * @return string
     */
    public function getCouponKey()
    {
        return $this->coupon_key;
    }

    /**
     * Set value
     *
     * @param decimal $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return decimal
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set max_usage
     *
     * @param int $maxUsage
     */
    public function setMaxUsage($maxUsage)
    {
        $this->max_usage = $maxUsage;
    }

    /**
     * Get max_usage
     *
     * @return int
     */
    public function getMaxUsage()
    {
        return $this->max_usage;
    }

    /**
     * Set expire_at
     *
     * @param datetime $expireAt
     */
    public function setExpireAt($expireAt)
    {
        $this->expire_at = $expireAt;
    }

    /**
     * Get expire_at
     *
     * @return datetime
     */
    public function getExpireAt()
    {
        return $this->expire_at;
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
      if (!$this->getId())
        $this->setCreatedAt(new \DateTime());
    }
}
