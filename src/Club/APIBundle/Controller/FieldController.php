<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/fields")
 */
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

    $fields = $em->getRepository('ClubBookingBundle:Field')->getFieldsOverview($location, $date);
    $data = $em->getRepository('ClubBookingBundle:Field')->getDayData($location, $date);
    $info = array(
      'start_time' => $data['start_time']->format('c'),
      'end_time' => $data['end_time']->format('c'),
    );

    $res = array(
      'info' => $info,
      'fields' => array()
    );
    foreach ($fields as $field) {
      $res['fields'][] = $field->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));

    return $response;
  }
}
