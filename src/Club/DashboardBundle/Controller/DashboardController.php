<?php

namespace Club\DashboardBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DashboardController extends Controller
{
  /**
   * @Template()
   * @Route("/user/dashboard")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine();

    $orders = $em->getRepository('ClubShopBundle:Order')->getOpenOrders(10,$this->get('security.context')->getToken()->getUser());

    $start = new \DateTime();
    $end = clone $start;
    $end->add(new \DateInterval('P1M'));

    $schedules = $em->getRepository('ClubTeamBundle:Schedule')->getAllBetween($start, $end, $this->get('security.context')->getToken()->getUser());

    return array(
      'orders' => $orders,
      'schedules' => $schedules
    );
  }
}
