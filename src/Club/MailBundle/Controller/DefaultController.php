<?php

namespace Club\MailBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
  /**
   * @Route("/mail",name="mail")
   * @Template()
   */
  public function indexAction()
  {
    return $this->render('ClubMailBundle:Default:index.html.twig');
  }
}
