<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminProductController extends Controller
{
  /**
   * @Route("/shop/product", name="admin_shop_product")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $products = $em->getRepository('\Club\ShopBundle\Entity\Product')->findAll();

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
    $em = $this->get('doctrine.orm.entity_manager');
    $product = $em->find('Club\ShopBundle\Entity\Product',$id);

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
    $em = $this->get('doctrine.orm.entity_manager');
    $product = $em->find('ClubShopBundle:Product',$this->get('request')->get('id'));

    $em->remove($product);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Product %s deleted.',$product->getProductName()));

    return new RedirectResponse($this->generateUrl('admin_shop_product'));
  }

  protected function process($product)
  {
    $form = $this->get('form.factory')->create(new \Club\ShopBundle\Form\Product(), $product);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($product);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_shop_product'));
      }
    }

    return $form;
  }
}
