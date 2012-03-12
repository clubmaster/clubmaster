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
     * @ORM\Column(type="string")
     *
     * @var string $controller
     */
    protected $controller;

    /**
     * @ORM\Column(type="text")
     *
     * @var string $success_page
     */
    protected $success_page;

    /**
     * @ORM\Column(type="text")
     *
     * @var string $error_page
     */
    protected $error_page;


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

    /**
     * Set controller
     *
     * @param string $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Get controller
     *
     * @return string 
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Set success_page
     *
     * @param text $successPage
     */
    public function setSuccessPage($successPage)
    {
        $this->success_page = $successPage;
    }

    /**
     * Get success_page
     *
     * @return text 
     */
    public function getSuccessPage()
    {
        return $this->success_page;
    }

    /**
     * Set error_page
     *
     * @param text $errorPage
     */
    public function setErrorPage($errorPage)
    {
        $this->error_page = $errorPage;
    }

    /**
     * Get error_page
     *
     * @return text 
     */
    public function getErrorPage()
    {
        return $this->error_page;
    }
}