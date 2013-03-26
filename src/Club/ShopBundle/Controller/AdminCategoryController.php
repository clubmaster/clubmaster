<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class AdminCategoryController extends Controller
{
  /**
   * @Route("/shop/category", name="admin_shop_category")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $categories = $em->getRepository('ClubShopBundle:Category')->findAll();

    return array(
      'categories' => $categories
    );
  }

  /**
   * @Route("/shop/category/new", name="admin_shop_category_new")
   * @Template()
   */
  public function newAction()
  {
    $category = new \Club\ShopBundle\Entity\Category();
    $res = $this->process($category);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/category/edit/{id}", name="admin_shop_category_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $category = $em->find('ClubShopBundle:Category',$id);

    $res = $this->process($category);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'category' => $category,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/category/delete/{id}", name="admin_shop_category_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $category = $em->find('ClubShopBundle:Category',$this->getRequest()->get('id'));

    $em->remove($category);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_shop_category'));
  }

  protected function process($category)
  {
    $form = $this->createForm(new \Club\ShopBundle\Form\Category(), $category);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_shop_category'));
      }
    }

    return $form;
  }
}
