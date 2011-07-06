<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
    $em = $this->getDoctrine()->getEntityManager();

    $shippings = $em->getRepository('ClubShopBundle:Shipping')->findAll();
    if (!count($shippings)) {
      throw new Exception('You need to have a least one shipping method');
    }

    if (count($shippings) == 1)
      $this->get('cart')->setShipping($shippings[0]);

    if (count($shippings) == 1 && $this->get('cart')->getCart()->getCustomerAddress())
      return $this->redirect($this->generateUrl('shop_checkout_payment'));

    $address = $this->get('cart')->getCart()->getCustomerAddress();
    if (!$address)
      $address = $this->getCustomerAddress($this->get('cart')->getCart());

    $form = $this->createForm(new \Club\ShopBundle\Form\CheckoutAddress(), $address);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $this->get('cart')->getCart()->setCustomerAddress($address);
        $this->get('cart')->getCart()->setShippingAddress($address);
        $this->get('cart')->getCart()->setBillingAddress($address);

        $em->persist($address);
        $em->flush();

        return $this->redirect($this->generateUrl('shop_checkout_payment'));
      }
    }

    return array(
      'form' => $form->createView(),
    );
  }

  /**
   * @Route("/shop/checkout/payment", name="shop_checkout_payment")
   * @Template()
   */
  public function paymentAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $payments = $em->getRepository('ClubShopBundle:PaymentMethod')->findAll();

    if (!count($payments)) {
      throw new Exception('You need to have at leats one payment method');
    }

    if (count($payments) == 1) {
      $this->get('cart')->setPayment($payments[0]);

      return $this->redirect($this->generateUrl('shop_checkout_review'));
    }

    $cart = $this->get('cart')->getCart();
    //$order = $em->merge($order);

    $form = $this->get('form.factory')
      ->createBuilder('form',$cart,array('validation_groups' => 'PaymentMethod'))
      ->add('payment_method','entity',array('class' => 'ClubShopBundle:PaymentMethod'))
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $this->get('cart')->setCart($cart);

        return $this->redirect($this->generateUrl('shop_checkout_review'));
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
    return array(
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
    }

    return $this->redirect($this->generateUrl('shop_checkout_confirm',array(
      'id' => $this->get('order')->getOrder()->getId()
    )));
  }

  /**
   * @Route("/shop/checkout/confirm/{id}", name="shop_checkout_confirm")
   * @Template()
   */
  public function confirmAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('ClubShopBundle:Order',$id);

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
    return $this->redirect($this->generateUrl('shop_checkout'));
  }

  protected function getCustomerAddress(\Club\ShopBundle\Entity\Cart $cart)
  {
    $profile = $cart->getUser()->getProfile();

    $address = new \Club\ShopBundle\Entity\CartAddress();
    $address->setFirstName($profile->getFirstName());
    $address->setLastName($profile->getLastName());

    return $address;
  }
}
