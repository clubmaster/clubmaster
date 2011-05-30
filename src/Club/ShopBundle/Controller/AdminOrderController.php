<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminOrderController extends Controller
{
  /**
   * @Route("/shop/order", name="admin_shop_order")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $orders = $em->getRepository('\Club\ShopBundle\Entity\Order')->findAll();

    return array(
      'orders' => $orders
    );
  }

  /**
   * @Route("/shop/order/edit/{id}", name="admin_shop_order_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $order = $em->find('\Club\ShopBundle\Entity\Order',$id);

    $res = $this->process($order);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'order' => $order,
      'page' => array('header' => 'Order'),
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/order/batch", name="admin_shop_order_batch")
   */
  public function batchAction()
  {
  }

  protected function process($order)
  {
    $form = $this->get('form.factory')->create(new \Club\ShopBundle\Form\Order(), $order);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($order);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_shop_order'));
      }
    }

    return $form;
  }
}
