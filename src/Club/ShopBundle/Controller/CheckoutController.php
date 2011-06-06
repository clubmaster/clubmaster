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
    $cart = $this->get('cart')->getCart();

    return array(
      'cart' => $cart
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

    if (count($shippings) == 1) {
      $this->get('cart')->setShipping($shippings[0]);

      return new RedirectResponse($this->generateUrl('shop_checkout_payment'));
    }

    return array();
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

    $cart = $this->get('cart')->getCart();
    //$order = $em->merge($order);

    $form = $this->get('form.factory')
      ->createBuilder('form',$cart,array('validation_groups' => 'PaymentMethod'))
      ->add('payment_method','entity',array('class' => 'Club\ShopBundle\Entity\PaymentMethod'))
      ->getForm();

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $this->get('cart')->setCart($cart);

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
    $user = $this->get('security.context')->getToken()->getUser();

    return array(
      'user' => $user,
      'cart' => $this->get('cart')->getCart()
    );
  }

  /**
   * @Route("/shop/checkout/process", name="shop_checkout_process")
   * @Template()
   */
  public function processAction()
  {
    if ($this->get('cart')->getCart()) {
      $this->get('order')->convertToOrder($this->get('cart')->getCart());

      $event = new \Club\ShopBundle\Event\FilterOrderEvent($this->get('order')->getOrder());
      $this->get('event_dispatcher')->dispatch(\Club\ShopBundle\Event\Events::onShopOrder, $event);
    }

    return new RedirectResponse($this->generateUrl('shop_checkout_confirm',array(
      'id' => $this->get('order')->getOrder()->getId()
    )));
  }

  /**
   * @Route("/shop/checkout/confirm/{id}", name="shop_checkout_confirm")
   * @Template()
   */
  public function confirmAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $order = $em->find('\Club\ShopBundle\Entity\Order',$id);

    return array(
      'order' => $order
    );
  }

  /**
   * @Route("/shop/cart/empty", name="shop_checkout_empty")
   */
  public function emptyCartAction()
  {
    $this->get('cart')->emptyCart();
    return new RedirectResponse($this->generateUrl('shop_checkout'));
  }
}
