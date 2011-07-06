<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminProductAttributeController extends Controller
{
  /**
   * @Route("/shop/product/attribute/{id}", name="admin_shop_product_attribute")
   * @Template()
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $product = $em->find('ClubShopBundle:Product',$id);

    return array(
      'product' => $product
    );
  }

  /**
   * @Route("/shop/product/attribute/{id}/new", name="admin_shop_product_attribute_new")
   * @Template()
   */
  public function newAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $product = $em->find('ClubShopBundle:Product',$id);

    $attr = new \Club\ShopBundle\Entity\ProductAttribute();
    $attr->setProduct($product);

    $res = $this->process($attr);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView(),
      'product' => $product
    );
  }

  /**
   * @Route("/shop/product/attribute/edit/{id}", name="admin_shop_product_attribute_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $attr = $em->find('ClubShopBundle:ProductAttribute',$id);

    $res = $this->process($attr);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'attr' => $attr,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/product/attribute/delete/{id}", name="admin_shop_product_attribute_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $attr = $em->find('ClubShopBundle:ProductAttribute',$id);

    $em->remove($attr);
    $em->flush();

    $this->get('session')->setFlash('notify','Changes has been saved.');

    return $this->redirect($this->generateUrl('admin_shop_product_attribute',array('id'=>$attr->getProduct()->getId())));
  }

  protected function process($attr)
  {
    $form = $this->createForm(new \Club\ShopBundle\Form\ProductAttribute(), $attr);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($attr);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return $this->redirect($this->generateUrl('admin_shop_product_attribute',array('id'=>$attr->getProduct()->getId())));
      }
    }

    return $form;
  }
}
