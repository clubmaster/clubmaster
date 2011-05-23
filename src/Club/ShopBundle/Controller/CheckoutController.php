<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\ShopBundle\Entity\PaymentMethod;
use Club\ShopBundle\Form\CheckoutPaymentForm;

class CheckoutController extends Controller
{
  /**
   * @Route("/shop/checkout", name="shop_checkout")
   * @Template()
   */
  public function indexAction()
  {
    $order = $this->get('basket')->getOrder();

    return array(
      'order' => $order
    );
  }

  /**
   * @Route("/shop/checkout/shipping", name="shop_checkout_shipping")
   * @Template()
   */
  public function shippingAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $shippings = $em->getRepository('Club\ShopBundle\Entity\Shipping')->findAll();
    if (!count($shippings)) {
      throw new Exception('You need to have a least one shipping method');
    }

    $basket = $this->get('basket')->getOrder();
    if (count($shippings) == 1) {
      $basket->setShipping($shippings[0]);

      return new RedirectResponse($this->generateUrl('shop_checkout_payment'));
    }
  }

  /**
   * @Route("/shop/checkout/payment", name="shop_checkout_payment")
   * @Template()
   */
  public function paymentAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $payments = $em->getRepository('Club\ShopBundle\Entity\PaymentMethod')->findAll();

    if (!count($payments)) {
      throw new Exception('You need to have at leats one payment method');
    }

    $basket = $this->get('basket');
    $order = $basket->getOrder();
    //$order = $em->merge($order);

    $form = $this->get('form.factory')
      ->createBuilder('form',$order,array('validation_groups' => 'PaymentMethod'))
      ->add('payment_method','entity',array('class' => 'Club\ShopBundle\Entity\PaymentMethod'))
      ->getForm();

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $basket->setOrder($order);

        return new RedirectResponse($this->generateUrl('shop_checkout_review'));
      }
    }
    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/shop/checkout/review", name="shop_checkout_review")
   * @Template()
   */
  public function reviewAction()
  {
    $order = $this->get('basket')->getOrder();

    $user = $this->get('security.context')->getToken()->getUser();

    return array(
      'user' => $user,
      'order' => $order
    );
  }

  /**
   * @Route("/shop/checkout/confirm", name="shop_checkout_confirm")
   * @Template()
   */
  public function confirmAction()
  {
    return array();
  }

  /**
   * @Route("/shop/basket/empty", name="shop_checkout_empty")
   */
  public function emptyBasketAction()
  {
    $this->get('basket')->emptyBasket();
    return new RedirectResponse($this->generateUrl('shop_checkout'));
  }
}
