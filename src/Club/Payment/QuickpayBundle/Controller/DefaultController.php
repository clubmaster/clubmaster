<?php

namespace Club\Payment\QuickpayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
  /**
   * @Route("/payment/quickpay/{order_id}")
   * @Template()
   */
  public function indexAction($order_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $order = $em->find('ClubShopBundle:Order', $order_id);

    $form = $this->createFormBuilder()
    return array(
      'order' => $order
    );
  }
}
