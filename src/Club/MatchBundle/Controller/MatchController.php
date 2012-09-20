<?php

namespace Club\MatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/match/match")
 */
class MatchController extends Controller
{
  /**
   * @Route("")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $matches = $em->getRepository('ClubMatchBundle:Match')->getRecentMatches(null, 50);

    return $this->render('ClubMatchBundle:Match:index.html.twig', array(
      'matches' => $matches
    ));
  }

  /**
   * @Route("/recent/{limit}")
   */
  public function recentAction($limit)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $matches = $em->getRepository('ClubMatchBundle:Match')->getRecentMatches(null, $limit);

    return $this->render('ClubMatchBundle:Match:recent_matches.html.twig', array(
      'matches' => $matches
    ));
  }

  /**
   * @Route("/new")
   * @Template()
   * @Secure(roles="ROLE_USER")
   */
  public function newAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $res = array();
    $res['user0'] = $this->get('security.context')->getToken()->getUser();

    $sets = 5;
    $form = $this->get('club_match.match')->getMatchForm($res, $sets);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        $this->get('club_match.match')->bindMatch($form->getData());

        if ($this->get('club_match.match')->isValid()) {
          $this->get('club_match.match')->save();
          $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

          return $this->redirect($this->generateUrl('club_match_match_index'));
        } else {
          $this->get('session')->setFlash('error', $this->get('club_match.match')->getError());
        }
      }
    }

    return array(
      'form' => $form->createView(),
      'sets' => $sets
    );
  }

  /**
   * @Route("/delete/{id}")
   * @Secure(roles="ROLE_USER")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $match = $em->find('ClubMatchBundle:Match',$id);

    if ($match->getProcessed(1))
      $this->get('club_match.league')->revokePoint($match);

    $em->remove($match);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_match_match_index'));
  }

  /**
   * @Route("/show/{id}")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $match = $em->find('ClubMatchBundle:Match',$id);

    return array(
      'match' => $match
    );
  }
}
