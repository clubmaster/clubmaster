<?php

namespace Club\RequestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/playermarket")
 */
class PlayerMarketController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $market = $em->getRepository('ClubRequestBundle:Request')->findAll();
    return array(
      'market' => $market
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    return array();
  }
}
