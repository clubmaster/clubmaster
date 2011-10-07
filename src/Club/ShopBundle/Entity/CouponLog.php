<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\CouponLog")
 * @ORM\Table(name="club_shop_coupon_log")
 * @ORM\HasLifecycleCallbacks
 *
 */
class CouponLog
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
     * @ORM\ManyToOne(targetEntity="Coupon")
     * @ORM\JoinColumn(name="coupon_id", onDelete="cascade")
     *
     * @var Club\ShopBundle\Entity\Coupon
     */
    private $coupon;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;


    public function __toString()
    {
      return $this->getVatName();
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
     * Set vat_name
     *
     * @param string $vatName
     */
    public function setVatName($vatName)
    {
        $this->vat_name = $vatName;
    }

    /**
     * Get vat_name
     *
     * @return string $vatName
     */
    public function getVatName()
    {
        return $this->vat_name;
    }

    /**
     * Set rate
     *
     * @param float $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get rate
     *
     * @return float $rate
     */
    public function getRate()
    {
        return $this->rate;
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
     * Set coupon
     *
     * @param Club\ShopBundle\Entity\Coupon $coupon
     */
    public function setCoupon(\Club\ShopBundle\Entity\Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Get coupon
     *
     * @return Club\ShopBundle\Entity\Coupon
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }

    /**
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     */
    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Club\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
