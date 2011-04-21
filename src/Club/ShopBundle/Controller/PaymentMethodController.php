<?php

namespace Club\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PaymentMethodController extends Controller
{
  /**
   * @extra:Route("/shop/category", name="shop_category")
   * @extra:Template()
   */
  public function indexAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');

    $categories = $em->getRepository('Club\ShopBundle\Entity\Category')->findAll();

    return array(
      'categories' => $categories
    );
  }

  /**
   * @extra:Route("/shop/category/delete/{id}", name="shop_category_delete")
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
   * @extra:Route("/shop/category/edit/{id}", name="shop_category_edit")
   */
  public function editAction($id)
  {
    return array();
  }
}
