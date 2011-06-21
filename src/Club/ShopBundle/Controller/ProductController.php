<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
  /**
   * @Route("/shop/product/{id}", name="shop_product")
   * @Template()
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $product = $em->find('Club\ShopBundle\Entity\Product',$id);

    return array(
      'product' => $product
    );
  }

  /**
   * @Route("/shop/product/cart/{id}", name="shop_product_cart")
   * @Template()
   */
  public function cartAction($id)
  {
    try {
      $product = $this->getDoctrine()->getEntityManager()->find('Club\ShopBundle\Entity\Product',$id);
      $this->get('cart')->addToCart($product);

    } catch (\Exception $e) {
      $this->get('session')->setFlash('notice',$e->getMessage());
    }

    return $this->redirect($this->generateUrl('shop_checkout'));
  }
}
