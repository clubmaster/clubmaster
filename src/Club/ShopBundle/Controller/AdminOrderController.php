<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminOrderController extends Controller
{
  /**
   * @Route("/shop/order/offset/{offset}", name="admin_shop_order_offset")
   * @Route("/shop/order", name="admin_shop_order")
   * @Template()
   */
  public function indexAction($offset = null)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $form = $this->createForm(new \Club\ShopBundle\Form\OrderQuery);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $data = $form->getData();

        $order = $em->getRepository('ClubShopBundle:Order')->findOneBy(array(
          'id' => $data['query']
        ));

        if ($order)
          return $this->redirect($this->generateUrl('admin_shop_order_edit', array('id' => $order->getId())));

        $this->get('session')->setFlash('error', $this->get('translator')->trans('There is no order with this number'));
      }
    }

    $count = $em->getRepository('ClubShopBundle:Order')->getCount($this->getFilter());
    $paginator = $this->get('club_paginator.paginator');
    $paginator->init($count, $offset);
    $paginator->setCurrentUrl('admin_shop_order_offset');

    $orders = $em->getRepository('ClubShopBundle:Order')->getWithPagination($this->getFilter(), null, $paginator->getOffset(), $paginator->getLimit());

    return array(
      'orders' => $orders,
      'paginator' => $paginator,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/shop/order/edit/{id}", name="admin_shop_order_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('ClubShopBundle:Order',$id);

    $form = $this->createForm(new \Club\ShopBundle\Form\Order(), $order);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $data = $form->getData();

        $this->get('order')->setOrder($order);
        $this->get('order')->changeStatus($data->getOrderStatus());

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_shop_order'));
      }
    }

    return array(
      'order' => $order,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/shop/order/delete/{id}", name="admin_shop_order_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('ClubShopBundle:Order',$id);

    $this->container->get('order')->setOrder($order);
    $status = $em->getRepository('ClubShopBundle:OrderStatus')->getCancelled();
    $this->container->get('order')->changeStatus($status);

    return $this->redirect($this->generateUrl('admin_shop_order'));
  }

  private function getFilter()
  {
    return unserialize($this->get('session')->get('order_filter'));
  }
}
