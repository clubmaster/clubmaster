<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/fields")
 */
class FieldController extends Controller
{
  /**
   * @Route("/modified")
   * @Method("GET")
   */
  public function modifiedAction()
  {
    $em = $this->getDoctrine()->getManager();

    $fields = $em->getRepository('ClubBookingBundle:Field')->findAll();

    $res = array();
    foreach ($fields as $field) {
      $i = $em->createQueryBuilder()
        ->select('i')
        ->from('ClubBookingBundle:Interval', 'i')
        ->where('i.field = :field')
        ->orderBy('i.updated_at', 'DESC')
        ->setMaxResults(1)
        ->setParameter('field', $field->getId())
        ->getQuery()
        ->getOneOrNullResult();

      $res[] = array(
        'field_id' => $field->getId(),
        'updated_at' => $i->getUpdatedAt()->format('c')
      );
    }

    $response = new Response($this->get('club_api.encode')->encode($res));

    return $response;
  }

  /**
   * @Route("/{location_id}", defaults={"date" = null})
   * @Route("/{location_id}/{date}")
   * @Method("GET")
   */
  public function indexAction($location_id, $date)
  {
    $em = $this->getDoctrine()->getManager();
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
