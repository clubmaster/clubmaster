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

    $event = new \Club\DashboardBundle\Event\FilterDashboardEvent();
    $this->get('event_dispatcher')->dispatch(\Club\DashboardBundle\Event\Events::onDashboardView, $event);

    return array(
      'output' => $event->getOutput()
    );
  }
}
