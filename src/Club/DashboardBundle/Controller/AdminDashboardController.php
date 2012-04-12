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

    $event = new \Club\UserBundle\Event\FilterOutputEvent();
    $this->get('event_dispatcher')->dispatch(\Club\DashboardBundle\Event\Events::onAdminDashboardView, $event);

    return array(
      'output' => $event->getOutput()
    );
  }
}
