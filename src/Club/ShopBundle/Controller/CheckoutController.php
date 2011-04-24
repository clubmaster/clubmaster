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
    $basket = $this->get('basket')->getBasket();
    $basket_items = $this->get('basket')->getBasketItems();

    return array(
      'basket' => $basket,
      'basket_items' => $basket_items
    );
  }

  /**
   * @extra:Route("/shop/checkout/payment", name="shop_checkout_payment")
   * @extra:Template()
   */
  public function paymentAction()
  {
    $payment = array();
    $form = CheckoutPaymentForm::create($this->get('form.context'),'payment_method',array(
      'em' => $this->get('doctrine.orm.entity_manager')
    ));

    if (is_array($this->get('request')->get('payment_method'))) {
      $request = $this->get('request')->get('payment_method');
      $this->get('request')->getSession()->set('order_payment',$request['payment']);

      return new RedirectResponse($this->generateUrl('shop_checkout_review'));
    }
    return array(
      'form' => $form
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

    $user = $this->get('security.context')->getToken()->getUser();
    $payment = $this->get('doctrine.orm.entity_manager')->find('Club\ShopBundle\Entity\PaymentMethod',$this->get('request')->getSession()->get('order_payment'));

    return array(
      'user' => $user,
      'payment' => $payment,
      'basket' => $basket,
      'basket_items' => $basket_items
    );
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
