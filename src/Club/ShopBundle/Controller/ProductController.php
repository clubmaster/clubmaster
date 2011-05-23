<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends Controller
{
  /**
   * @Route("/shop/product/{category}", name="shop_product")
   * @Template()
   */
  public function indexAction($category)
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $products = $em->getRepository('Club\ShopBundle\Entity\Product')->findByCategories(array($category));

    return array(
      'products' => $products
    );
  }

  /**
   * @Route("/shop/product/delete/{id}", name="shop_product_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $category = $em->find('Club\ShopBundle\Entity\Category',$id);

    $em->remove($category);
    $em->flush();

    return new RedirectResponse($this->generateUrl('shop_category'));
  }

  /**
   * @Route("/shop/product/edit/{id}", name="shop_product_edit")
   */
  public function editAction($id)
  {
    return array();
  }

  /**
   * @Route("/shop/product/basket/{id}", name="shop_product_basket")
   * @Template()
   */
  public function basketAction($id)
  {
    $product = $this->get('doctrine.orm.entity_manager')->find('Club\ShopBundle\Entity\Product',$id);

    $this->get('basket')->addToBasket($product);

    return new RedirectResponse($this->generateUrl('shop_checkout'));
  }
}
