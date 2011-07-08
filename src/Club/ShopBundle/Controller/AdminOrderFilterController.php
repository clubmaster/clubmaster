<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminOrderFilterController extends Controller
{
  /**
   * @Route("/shop/order/filter")
   */
  public function filterAction()
  {
    $form = $this->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $this->setData($form);
      }
    }

    return $this->redirect($this->generateUrl('admin_shop_order'));
  }

  public function getFilterAction()
  {
    $form = $this->getForm();
    $form->setData($this->getData());

    return $this->render('ClubShopBundle:AdminOrderFilter:form.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * Build the form filter
   */
  private function getForm()
  {
    return $this->createFormBuilder()
      ->add('order_number','text')
      ->getForm();
  }

  private function setData($form)
  {
    $this->get('session')->set('order_filter',serialize($form->getData()));
  }

  private function getData()
  {
    return unserialize($this->get('session')->get('order_filter'));
  }
}
