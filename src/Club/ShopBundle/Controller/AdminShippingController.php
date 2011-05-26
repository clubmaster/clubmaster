<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminShippingController extends Controller
{
  /**
   * @Route("/shop/shipping", name="admin_shop_shipping")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $shippings = $em->getRepository('\Club\ShopBundle\Entity\Shipping')->findAll();

    return array(
      'shippings' => $shippings
    );
  }

  /**
   * @Route("/shop/shipping/new", name="admin_shop_shipping_new")
   * @Template()
   */
  public function newAction()
  {
    $shipping = new \Club\ShopBundle\Entity\Shipping();
    $res = $this->process($shipping);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'page' => array('header' => 'Shipping'),
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/shipping/edit/{id}", name="admin_shop_shipping_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $shipping = $em->find('Club\ShopBundle\Entity\Shipping',$id);

    $res = $this->process($shipping);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'shipping' => $shipping,
      'page' => array('header' => 'Shipping'),
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/shipping/delete/{id}", name="admin_shop_shipping_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $shipping = $em->find('ClubShopBundle:Shipping',$this->get('request')->get('id'));

    $em->remove($shipping);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Shipping %s deleted.',$shipping->getShippingName()));

    return new RedirectResponse($this->generateUrl('admin_shop_shipping'));
  }

  /**
   * @Route("/shop/shipping/batch", name="admin_shop_shipping_batch")
   */
  public function batchAction()
  {
  }

  protected function process($shipping)
  {
    $form = $this->get('form.factory')->create(new \Club\ShopBundle\Form\Shipping(), $shipping);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($shipping);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_shop_shipping'));
      }
    }

    return $form;
  }
}
