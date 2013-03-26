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
    $em = $this->getDoctrine()->getManager();
    $rankings = $em->getRepository('ClubRankingBundle:Ranking')->findAll();

    return array(
      'rankings' => $rankings,
      'ranking_view_top' => $this->get('service_container')->getParameter('club_ranking.ranking_top')
    );
  }

  /**
   * @Route("/show/{id}")
   * @Template()
   */
  public function showAction(\Club\RankingBundle\Entity\Ranking $ranking)
  {
      $em = $this->getDoctrine()->getManager();
      $matches = $em->getRepository('ClubRankingBundle:Ranking')->getRecentMatches($ranking, 10);

      return array(
          'ranking' => $ranking,
          'matches' => $matches
      );
  }

  /**
   * @Route("/recent/{id}/{limit}")
   * @Template()
   */
  public function recentMatchesAction(\Club\RankingBundle\Entity\Ranking $ranking, $limit)
  {
    $em = $this->getDoctrine()->getManager();
    $matches = $em->getRepository('ClubRankingBundle:Ranking')->getRecentMatches($ranking, $limit);

    return $this->render('ClubMatchBundle:Match:recent_matches.html.twig', array(
      'matches' => $matches
    ));
  }

  /**
   * @Route("/top/{id}/{limit}")
   * @Template()
   */
  public function topAction($id, $limit)
  {
    $em = $this->getDoctrine()->getManager();

    $ranking = $em->find('ClubRankingBundle:Ranking', $id);
    $rank = $em->getRepository('ClubRankingBundle:Ranking')->getTop($ranking, $limit);

    return array(
      'rank' => $rank
    );
  }
}
