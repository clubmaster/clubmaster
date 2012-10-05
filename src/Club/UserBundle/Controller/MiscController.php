<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MiscController extends Controller
{
  public function locationBarAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $location = $em->find('ClubUserBundle:Location', $this->get('session')->get('location_id'));
    $locations = $em->getRepository('ClubUserBundle:Location')->findAll();

    return $this->render('ClubUserBundle:Misc:locationBar.html.twig', array(
      'location' => $location,
      'locations' => $locations
    ));
  }
}
