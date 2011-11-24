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
   * @Route("/{location_id}", defaults={"date" = null})
   * @Route("/{location_id}/{date}")
   * @Method("GET")
   */
  public function indexAction($location_id, $date)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $location = $em->find('ClubUserBundle:Location', $location_id);

    $date = ($date == null) ? new \DateTime() : new \DateTime($date);

    $fields = $em->getRepository('ClubBookingBundle:Field')->getFieldsOverview($location,$date);

    $res = array();
    foreach ($fields as $field) {
      $res[] = $field->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));

    return $response;
  }
}
