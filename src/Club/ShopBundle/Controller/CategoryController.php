<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CategoryController extends Controller
{
  /**
   * @Route("/shop/category", name="shop_category")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $categories = $em->getRepository('Club\ShopBundle\Entity\Category')->findAll();

    return array(
      'categories' => $categories
    );
  }

  /**
   * @Route("/shop/category/delete/{id}", name="shop_category_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $category = $em->find('Club\ShopBundle\Entity\Category',$id);

    $em->remove($category);
    $em->flush();

    return $this->redirect($this->generateUrl('shop_category'));
  }

  /**
   * @Route("/shop/category/edit/{id}", name="shop_category_edit")
   */
  public function editAction($id)
  {
    return array();
  }
}
