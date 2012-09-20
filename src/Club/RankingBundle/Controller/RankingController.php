<?php

namespace Club\RankingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/ranking")
 */
class RankingController extends Controller
{
  /**
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $rankings = $em->getRepository('ClubRankingBundle:Ranking')->findAll();

    return array(
      'rankings' => $rankings,
      'ranking_view_top' => $this->get('service_container')->getParameter('club_match.ranking_view_top')
    );
  }

  /**
   * @Route("/show/{id}")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $ranking = $em->find('ClubRankingBundle:Ranking', $id);

    return array(
      'ranking' => $ranking
    );
  }

  /**
   * @Route("/recent/{id}/{limit}")
   * @Template()
   */
  public function recentMatchesAction($id, $limit)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $ranking = $em->find('ClubRankingBundle:Ranking', $id);
    $matches = $em->getRepository('ClubMatchBundle:Match')->getRecentMatches($ranking, $limit);

    return array(
      'matches' => $matches
    );
  }

  /**
   * @Route("/top/{id}/{limit}")
   * @Template()
   */
  public function topAction($id, $limit)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $ranking = $em->find('ClubRankingBundle:Ranking', $id);
    $rank = $em->getRepository('ClubRankingBundle:Ranking')->getTop($ranking, $limit);

    return array(
      'rank' => $rank
    );
  }
}
