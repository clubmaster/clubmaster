<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class LoginLogController extends Controller
{
  /**
   * @Route("/log/login")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $logs = $em->getRepository('ClubUserBundle:LoginAttempt')->findBy(
      array(),
      array('id' => 'DESC'),
      50
    );

    return array(
      'logs' => $logs
    );
  }
}
