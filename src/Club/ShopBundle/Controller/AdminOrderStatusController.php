<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class AdminOrderStatusController extends Controller
{
  /**
   * @Route("/shop/orderstatus")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $orderstatuses = $em->getRepository('ClubShopBundle:OrderStatus')->findAll();

    return array(
      'orderstatuses' => $orderstatuses
    );
  }

  /**
   * @Route("/shop/orderstatus/new")
   * @Template()
   */
  public function newAction()
  {
    $orderstatus = new \Club\ShopBundle\Entity\OrderStatus();
    $res = $this->process($orderstatus);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/orderstatus/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $orderstatus = $em->find('ClubShopBundle:OrderStatus',$id);

    $res = $this->process($orderstatus);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'orderstatus' => $orderstatus,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/orderstatus/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $orderstatus = $em->find('ClubShopBundle:OrderStatus',$this->getRequest()->get('id'));

    $em->remove($orderstatus);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_shop_adminorderstatus_index'));
  }

  protected function process($orderstatus)
  {
    $form = $this->createForm(new \Club\ShopBundle\Form\OrderStatus(), $orderstatus);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($orderstatus);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_shop_adminorderstatus_index'));
      }
    }

    return $form;
  }
}
