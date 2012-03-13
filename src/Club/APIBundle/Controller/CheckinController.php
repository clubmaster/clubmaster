<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

class CheckinController extends Controller
{
  /**
   * @Route("/checkin")
   * @Secure(roles="ROLE_USER")
   */
  public function checkinAction()
  {
    if (!$this->validateKey())
      return new Response($this->get('club_api.encode')->encodeError('Wrong API key'), 403);

    $em = $this->getDoctrine()->getEntityManager();
    $checkin = new \Club\CheckinBundle\Entity\Checkin();
    $checkin->setUser($this->get('security.context')->getToken()->getUser());

    $em->persist($checkin);
    $em->flush();

    $event = new \Club\CheckinBundle\Event\FilterCheckinEvent($checkin);
    $this->get('event_dispatcher')->dispatch(\Club\CheckinBundle\Event\Events::onCheckin, $event);

    $response = new Response();
    return $response;
  }
}
