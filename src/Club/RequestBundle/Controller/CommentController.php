<?php

namespace Club\RequestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/playermarket/comment")
 */
class CommentController extends Controller
{
  /**
   * @Route("/new/{id}")
   * @Template()
   */
  public function newAction(\Club\RequestBundle\Entity\Request $request)
  {
    $market = $em->getRepository('ClubRequestBundle:Request')->findAll();
    return array(
      'market' => $market
    );
  }
}
