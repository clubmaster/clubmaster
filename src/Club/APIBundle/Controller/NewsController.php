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
    $em = $this->getDoctrine()->getManager();
    $announcements = $em->getRepository('ClubNewsBundle:Announcement')->getOpen();

    $res = array();
    foreach ($announcements as $announcement) {
      $res[] = $announcement->toArray();
    }

    $response = new Response($this->get('club_api.encode')->encode($res));
    return $response;
  }
}
