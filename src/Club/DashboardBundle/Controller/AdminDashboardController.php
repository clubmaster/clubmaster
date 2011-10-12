<?php

namespace Club\DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdminDashboardController extends Controller
{
  /**
   * @Template()
   * @Route("/dashboard")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine();

    $orders = $em->getRepository('ClubShopBundle:Order')->findBy(array(
      'order_status' => 1
    ));

    return array(
      'orders' => $orders
    );
  }
}
