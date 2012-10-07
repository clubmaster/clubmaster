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
    $event = new \Club\UserBundle\Event\FilterOutputEvent($this->getUser());
    $this->get('event_dispatcher')->dispatch(\Club\DashboardBundle\Event\Events::onDashboardView, $event);

    $event2 = new \Club\UserBundle\Event\FilterActivityEvent($this->getUser());
    $this->get('event_dispatcher')->dispatch(\Club\DashboardBundle\Event\Events::onDashboardComing, $event2);

    $activities = $event2->getActivities();
    ksort($activities);

    $event3 = new \Club\UserBundle\Event\FilterActivityEvent($this->getUser());
    $this->get('event_dispatcher')->dispatch(\Club\DashboardBundle\Event\Events::onDashboardRecent, $event3);

    return array(
      'output' => $event->getOutput(),
      'activities' => $activities,
      'recent' => $event3->getActivities()
    );
  }
}
