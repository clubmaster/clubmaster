<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminCategoryController extends Controller
{
  /**
   * @Route("/shop/category", name="admin_shop_category")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $categories = $em->getRepository('\Club\ShopBundle\Entity\Category')->findAll();

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
    $em = $this->getDoctrine()->getEntityManager();
    $category = $em->find('Club\ShopBundle\Entity\Category',$id);

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
    $em = $this->getDoctrine()->getEntityManager();
    $category = $em->find('ClubShopBundle:Category',$this->get('request')->get('id'));

    $em->remove($category);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Category %s deleted.',$category->getCategoryName()));

    return new RedirectResponse($this->generateUrl('admin_shop_category'));
  }

  protected function process($category)
  {
    $form = $this->get('form.factory')->create(new \Club\ShopBundle\Form\Category(), $category);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($category);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_shop_category'));
      }
    }

    return $form;
  }
}
