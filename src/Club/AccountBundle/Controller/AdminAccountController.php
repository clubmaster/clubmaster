<?php

namespace Club\AccountBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminAccountController extends Controller
{
  /**
   * @Route("/account")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $this->get('security.context')->getToken()->getUser();

    $accounts = $em->getRepository('ClubAccountBundle:Account')->findAll();

    return array(
      'accounts' => $accounts
    );
  }
}
