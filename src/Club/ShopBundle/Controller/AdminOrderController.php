<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/shop/order")
 */
class AdminOrderController extends Controller
{
  /**
   * @Route("/user/{id}")
   * @Template()
   */
  public function userAction(\Club\UserBundle\Entity\User $user)
  {
      $em = $this->getDoctrine()->getManager();

      $orders = $em->getRepository('ClubShopBundle:Order')->findBy(
          array(
              'user' => $user->getId(),
          ),
          array(
              'id' => 'DESC'
          ),
          20
      );

      return array(
          'orders' => $orders
      );
  }

  /**
   * @Route("/page/{page}", name="admin_shop_order_page")
   * @Route("", name="admin_shop_order")
   * @Template()
   */
  public function indexAction($page = null)
  {
    $em = $this->getDoctrine()->getManager();

    $form = $this->createForm(new \Club\ShopBundle\Form\OrderQuery);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
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
    $nav = $this->get('club_paginator.paginator')
        ->init(20, $count, $page, 'admin_shop_order_page');

    $orders = $em->getRepository('ClubShopBundle:Order')->getWithPagination($this->getFilter(), null, $nav->getOffset(), $nav->getLimit());

    return array(
      'orders' => $orders,
      'nav' => $nav,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/edit/{id}", name="admin_shop_order_edit")
   * @Template()
   */
  public function editAction(\Club\ShopBundle\Entity\Order $order)
  {
    $em = $this->getDoctrine()->getManager();

    return array(
      'order' => $order
    );
  }

  /**
   * @Route("/delete/{id}", name="admin_shop_order_delete")
   */
  public function deleteAction(\Club\ShopBundle\Entity\Order $order)
  {
    $em = $this->getDoctrine()->getManager();

    $this->container->get('order')->setOrder($order);
    $this->get('order')->setCancelled();

    $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your order has been cancelled'));

    return $this->redirect($this->generateUrl('admin_shop_order'));
  }

  private function getFilter()
  {
    return unserialize($this->get('session')->get('order_filter'));
  }

  /**
   * @Route("/deliver/{id}")
   */
  public function deliverAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $order = $em->find('ClubShopBundle:Order',$id);

    $status = $em->getRepository('ClubShopBundle:OrderStatus')->getDelivered();

    $this->get('order')->setOrder($order);
    $this->get('order')->changeStatus($status);

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_shop_order_edit', array(
        'id' => $order->getId()
    )));
  }

  /**
   * @Route("/product/edit/{id}")
   * @Template()
   */
  public function productEditAction(\Club\ShopBundle\Entity\Order $order)
  {
    $em = $this->getDoctrine()->getManager();

    if ($order->getPaid() || $order->getCancelled() || $order->getDelivered()) {
      $this->get('session')->setFlash('error', $this->get('translator')->trans('You cannot chance a order which has been processed'));

      return $this->redirect($this->generateUrl('admin_shop_order_edit', array('id' => $order->getId())));
    }

    $form = $this->createForm(new \Club\ShopBundle\Form\OrderType, $order);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {

        $this->get('order')->setOrder($order);
        $this->get('order')->recalcPrice();

        $em->persist($order);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_shop_order_edit', array('id' => $order->getId())));
      }
    }

    return array(
      'order' => $order,
      'form' => $form->createView()
    );
  }

}
