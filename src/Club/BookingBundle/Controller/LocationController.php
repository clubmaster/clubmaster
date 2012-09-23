<?php

namespace Club\BookingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/booking")
 */
class LocationController extends Controller
{
  /**
   * @Template()
   * @Route("/location")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $locations = $em->getRepository('ClubBookingBundle:Field')->getLocationWithFields();

    return array(
      'locations' => $locations
    );
  }

  /**
   * @Route("/location/{id}")
   */
  public function switchAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $user = $this->getUser();
    $location = $em->find('ClubUserBundle:Location',$id);

    $this->get('session')->set('location_id', $location->getId());
    $this->get('session')->set('location_name', $location->getLocationName());

    if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
      $user->setLocation($location);
      $em->persist($user);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('club_booking_overview_index'));
  }
}
