<?php

namespace Club\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
   * @extra:Route("/shop/basket/empty", name="shop_checkout_empty")
   */
  public function emptyBasketAction()
  {
    $this->get('basket')->emptyBasket();
    return new RedirectResponse($this->generateUrl('shop_checkout'));
  }
}
