<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MemberController extends Controller
{
  /**
   * @Template()
   * @Route("/members/")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $users = $em->getRepository('ClubUserBundle:User')->findAll();

    return array(
      'users' => $users
    );
  }
}
