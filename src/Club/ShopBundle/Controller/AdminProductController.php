<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class AdminProductController extends Controller
{
  /**
   * @Route("/shop/product", name="admin_shop_product")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $categories = $em->getRepository('ClubShopBundle:Category')->findAll();

    if (!count($categories)) {
      return $this->forward('ClubShopBundle:AdminProduct:noCategory');
    }

    $products = $em->getRepository('ClubShopBundle:Product')->findAll();

    return array(
      'products' => $products
    );
  }

  /**
   * @Route("/shop/product/new", name="admin_shop_product_new")
   * @Template()
   */
  public function newAction()
  {
    $product = new \Club\ShopBundle\Entity\Product();
    $res = $this->process($product);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/product/edit/{id}", name="admin_shop_product_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $product = $em->find('ClubShopBundle:Product',$id);

    $res = $this->process($product);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'product' => $product,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/product/delete/{id}", name="admin_shop_product_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $product = $em->find('ClubShopBundle:Product',$this->getRequest()->get('id'));

    $em->remove($product);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_shop_product'));
  }

  /**
   * @Route("/shop/product/no_category")
   * @Template()
   */
  public function noCategoryAction()
  {
    return array();
  }

  protected function process($product)
  {
    $form = $this->createForm(new \Club\ShopBundle\Form\Product(), $product);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_shop_product'));
      }
    }

    return $form;
  }
}
