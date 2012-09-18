<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/locations")
 */
class LocationController extends Controller
{
  /**
   * @Route("")
   * @Method("GET")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $locations = $em->getRepository('ClubUserBundle:Location')->findAll();

    $res = array();
    foreach ($locations as $location) {
      $res[] = $location->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));

    return $response;
  }
}
