<?php

namespace Club\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\ShopBundle\Entity\PaymentMethod;
use Club\ShopBundle\Form\CheckoutPaymentForm;

class CheckoutController extends Controller
{
  /**
   * @extra:Route("/shop/checkout", name="shop_checkout")
   * @extra:Template()
   */
  public function indexAction()
  {
    $order = $this->get('basket')->getOrder();

    return array(
      'order' => $order
    );
  }

  /**
   * @extra:Route("/shop/checkout/shipping", name="shop_checkout_shipping")
   * @extra:Template()
   */
  public function shippingAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $shippings = $em->getRepository('Club\ShopBundle\Entity\Shipping')->findAll();
    if (!count($shippings)) {
      throw new Exception('You need to have a least one shipping method');
    }

    $order = new \Club\ShopBundle\Entity\Order();
    if (count($shippings) == 1) {
      $basket = $this->get('basket');
      $basket->setOrder($order);

      return new RedirectResponse($this->generateUrl('shop_checkout_payment'));
    }

    $form = CheckoutPaymentForm::create($this->get('form.context'),'shipping_method',array(
      'em' => $this->get('doctrine.orm.entity_manager')
    ));

    if (is_array($this->get('request')->get('shipping_method'))) {
      $request = $this->get('request')->get('shipping_method');
      $this->get('request')->getSession()->set('order_shipping',$request['shipping']);

      return new RedirectResponse($this->generateUrl('shop_checkout_payment'));
    }
    return array(
      'form' => $form
    );
  }

  /**
   * @extra:Route("/shop/checkout/payment", name="shop_checkout_payment")
   * @extra:Template()
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
    $order = $em->merge($order);

    if (count($payments) == 1) {
      $basket = $this->get('basket');
      $order->setPaymentMethod($payments[0]);
      $basket->setOrder($order);

      return new RedirectResponse($this->generateUrl('shop_checkout_review'));
    }

    $form = $this->get('form.factory')
      ->createBuilder('form',$order,array('validation_groups' => 'PaymentMethod'))
      ->add('payment_method','entity',array('class' => 'Club\ShopBundle\Entity\PaymentMethod'))
      ->getForm();

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {

        $basket = $this->get('basket');
        $basket->setOrder($order);

        return new RedirectResponse($this->generateUrl('shop_checkout_review'));
      }
    }
    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @extra:Route("/shop/checkout/review", name="shop_checkout_review")
   * @extra:Template()
   */
  public function reviewAction()
  {
    $basket = $this->get('basket')->getBasket();
    $basket_items = $this->get('basket')->getBasketItems();

    $order = $this->get('basket')->getOrder();

    $user = $this->get('security.context')->getToken()->getUser();
    $payment = $this->get('doctrine.orm.entity_manager')->find('Club\ShopBundle\Entity\PaymentMethod',$this->get('request')->getSession()->get('order_payment'));

    return array(
      'user' => $user,
      'payment' => $payment,
      'basket' => $basket,
      'basket_items' => $basket_items,
      'order' => $order
    );
  }

  /**
   * @extra:Route("/shop/checkout/confirm", name="shop_checkout_confirm")
   * @extra:Template()
   */
  public function confirmAction()
  {
    return array();
  }

  /**
   * @extra:Route("/shop/basket/empty", name="shop_checkout_empty")
   */
  public function emptyBasketAction()
  {
    $this->get('basket')->emptyBasket();
    return new RedirectResponse($this->generateUrl('shop_checkout'));
  }
}
