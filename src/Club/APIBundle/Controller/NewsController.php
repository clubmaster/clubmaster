<?php

namespace Club\APIBundle\Controller;

use Club\APIBundle\Controller\DefaultController as Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/news")
 */
class NewsController extends Controller
{
  /**
   * @Route("")
   * @Method("GET")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $tickers = $em->getRepository('ClubNewsBundle:Ticker')->getOpen();

    $res = array();
    foreach ($tickers as $ticker) {
      $res[] = $ticker->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));
    return $response;
  }
}
