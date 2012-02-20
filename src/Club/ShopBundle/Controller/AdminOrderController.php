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

    $count = $em->getRepository('ClubShopBundle:Order')->getCount($this->getFilter());
    $paginator = new \Club\UserBundle\Helper\Paginator($count, $this->generateUrl('admin_shop_order'));
    $orders = $em->getRepository('ClubShopBundle:Order')->getWithPagination($this->getFilter(), null, $paginator->getOffset(), $paginator->getLimit());

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

    $em->remove($order);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_shop_order'));
  }

  private function getFilter()
  {
    return unserialize($this->get('session')->get('order_filter'));
  }
}
