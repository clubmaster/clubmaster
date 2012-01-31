<?php

namespace Club\WelcomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller
{
  /**
   * @Route("/welcome")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $welcome = $em->getRepository('ClubWelcomeBundle:Welcome')->findOneBy(array(
      'location' => 1
    ));

    return array(
      'welcome' => $welcome
    );
  }
}
