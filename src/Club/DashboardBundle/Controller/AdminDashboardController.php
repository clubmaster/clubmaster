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

    $orders = $em->getRepository('ClubShopBundle:Order')->findBy(
      array(
        'order_status' => 1
      ),
      null,
      10
    );

    $users = $em->getRepository('ClubUserBundle:User')->findBy(
      array(),
      array(
        'id' => 'DESC'
      ),
      10
    );

    $logs = $em->getRepository('ClubLogBundle:Log')->getRecent(10);

    return array(
      'orders' => $orders,
      'users' => $users,
      'logs' => $logs
    );
  }
}
