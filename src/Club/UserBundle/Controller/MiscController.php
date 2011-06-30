<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MiscController extends Controller
{
  public function locationBarAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $locations = $em->getRepository('ClubUserBundle:Location')->findAllVisible();

    return $this->render('ClubUserBundle:Misc:locationBar.html.twig', array(
      'locations' => $locations
    ));
  }
}
