<?php

namespace Club\WelcomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/blog/rss")
 */
class RssController extends Controller
{
  /**
   * @Route("/latest-rss")
   * @Template()
   */
  public function latestAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $blog = $em->getRepository('ClubWelcomeBundle:Blog')->findBy(
        array(),
        array('id' => 'DESC'),
        10
    );

    $response = $this->render('ClubWelcomeBundle:Rss:latest.html.twig', array(
        'blog' => $blog,
        'pubDate_format' => \DateTime::RSS
    ));
    $response->headers->set('Content-Type', 'text/xml');

    return $response;
  }
}
