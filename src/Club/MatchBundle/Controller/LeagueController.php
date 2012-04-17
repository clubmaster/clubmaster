<?php

namespace Club\MatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LeagueController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $leagues = $em->getRepository('ClubMatchBundle:League')->findAll();

    return array(
      'leagues' => $leagues
    );
  }

  /**
   * @Route("/recent/{id}")
   * @Template()
   */
  public function recentMatchesAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $league = $em->find('ClubMatchBundle:League', $id);
    $matches = $em->getRepository('ClubMatchBundle:League')->getRecentMatches($league);

    return array(
      'matches' => $matches
    );
  }

  /**
   * @Route("/top/{id}")
   * @Template()
   */
  public function topAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $league = $em->find('ClubMatchBundle:League', $id);
    $rank = $em->getRepository('ClubMatchBundle:League')->getTop($league);

    return array(
      'rank' => $rank
    );
  }

}
