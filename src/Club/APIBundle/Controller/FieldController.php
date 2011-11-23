<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


class FieldController extends Controller
{
  /**
   * @Route("/{location_id}")
   * @Method("GET")
   */
  public function indexAction($location_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $location = $em->find('ClubUserBundle:Location', $location_id);

    $fields = $em->getRepository('ClubBookingBundle:Field')->getFieldsOverview(
      $location,
      new \DateTime()
    );

    $res = array();
    foreach ($fields as $field) {
      $res[] = $field->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));
    $response->headers->set('Access-Control-Allow-Origin', '*');

    return $response;
  }
}
