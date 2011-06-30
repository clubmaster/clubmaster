<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminOrderController extends Controller
{
  /**
   * @Route("/shop/order", name="admin_shop_order")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $count = $em->getRepository('ClubShopBundle:Order')->getCount();
    $paginator = new \Club\UserBundle\Helper\Paginator($count, $this->generateUrl('admin_shop_order'));
    $orders = $em->getRepository('ClubShopBundle:Order')->getWithPagination(null, null, $paginator->getOffset(), $paginator->getLimit());

    return array(
      'orders' => $orders,
      'paginator' => $paginator
    );
  }

  /**
   * @Route("/shop/order/edit/{id}", name="admin_shop_order_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('\Club\ShopBundle\Entity\Order',$id);

    $form = $this->createForm(new \Club\ShopBundle\Form\Order(), $order);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($order);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        $event = new \Club\ShopBundle\Event\FilterOrderEvent($order);
        $this->get('event_dispatcher')->dispatch(\Club\ShopBundle\Event\Events::onOrderChange, $event);

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
    $order = $em->find('\Club\ShopBundle\Entity\Order',$id);

    $em->remove($order);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_shop_order'));
  }
}
