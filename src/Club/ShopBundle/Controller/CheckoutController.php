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
   * @Route("/shop/cart/increment/{id}")
   */
  public function incrementAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $product = $em->getRepository('ClubShopBundle:CartProduct')->find($id);
    $this->get('cart')->modifyQuantity($product);

    return $this->redirect($this->generateUrl('shop_checkout'));
  }

  /**
   * @Route("/shop/cart/decrement/{id}")
   */
  public function decrementAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $product = $em->getRepository('ClubShopBundle:CartProduct')->find($id);
    $this->get('cart')->modifyQuantity($product,-1);

    return $this->redirect($this->generateUrl('shop_checkout'));
  }

  /**
   * @Route("/shop/checkout/shipping", name="shop_checkout_shipping")
   * @Template()
   */
  public function shippingAction()
  {
    if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
      return $this->redirect($this->generateUrl('club_shop_checkout_signin'));

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

    $cart = $this->get('cart')->getCart();
    $form1 = $this->createForm(new \Club\ShopBundle\Form\CheckoutShipping(), $cart);

    $form2 = $this->createForm(new \Club\ShopBundle\Form\CheckoutAddress(), $address);

    if ($this->getRequest()->getMethod() == 'POST') {
      if ($this->getRequest()->get($form1->getName())) {
        $form1->bindRequest($this->getRequest());
        if ($form1->isValid()) {
          $this->get('cart')->setCart($cart);
        }
      }
      if ($this->getRequest()->get($form2->getName())) {
        $form2->bindRequest($this->getRequest());

        if ($form2->isValid()) {
          $this->get('cart')->getCart()->setCustomerAddress($address);
          $this->get('cart')->getCart()->setShippingAddress($address);
          $this->get('cart')->getCart()->setBillingAddress($address);

          $em->persist($address);
          $em->flush();
        }
      }

      return $this->redirect($this->generateUrl('shop_checkout_payment'));
    }

    return array(
      'form1' => $form1->createView(),
      'form2' => $form2->createView(),
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
    $form = $this->createForm(new \Club\ShopBundle\Form\CheckoutPayment(), $cart);

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
    $cart = $this->get('cart')->getCart();

    if ($cart) {
      $em = $this->getDoctrine()->getEntityManager();
      $shipping = $cart->getShipping();

      if ($shipping->getPrice() > 0) {
        $product = array(
          'product_name' => $shipping->getShippingName(),
          'price' => $shipping->getPrice(),
          'type' => 'shipping'
        );
        $this->get('cart')->addToCart($product);
      }
      $this->get('order')->convertToOrder($cart);
    } else {
      return $this->redirect($this->generateUrl('shop'));
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

  /**
   * @Route("/shop/signin")
   * @Template()
   */
  public function signinAction()
  {
    $user = new \Club\UserBundle\Entity\User();

    $user_form = $this->createForm(new \Club\UserBundle\Form\User(), $user);
    $this->get('session')->set('_security.target_path', '/shop/login');

    return array(
      'user_form' => $user_form->createView(),
    );
  }

  /**
   * @Route("/shop/login")
   * @Template()
   */
  public function loginAction()
  {
    $this->get('cart')->setUser();
    $this->get('cart')->save();

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
