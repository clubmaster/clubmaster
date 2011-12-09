<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\PaymentMethodRepository")
 * @ORM\Table(name="club_shop_payment_method")
 */
class PaymentMethod
{
    /**
     * @ORM\id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $payment_method_name
     */
    protected $payment_method_name;

    /**
     * @ORM\Column(type="text")
     *
     * @var string $page
     */
    protected $page;


    public function __toString()
    {
      return $this->getPaymentMethodName();
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

    public function setId($id)
    {
      $this->id = $id;
    }

    /**
     * Set payment_method_name
     *
     * @param string $paymentMethodName
     */
    public function setPaymentMethodName($paymentMethodName)
    {
        $this->payment_method_name= $paymentMethodName;
    }

    /**
     * Get payment_method_name
     *
     * @return string $paymentMethodName
     */
    public function getPaymentMethodName()
    {
        return $this->payment_method_name;
    }

    public function setPage($page)
    {
      $this->page = $page;
    }

    public function getPage()
    {
      return $this->page;
    }
}
