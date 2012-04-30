<?php

namespace Club\MatchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MatchController extends Controller
{
  /**
   * @Route("/recent/{limit}")
   */
  public function recentAction($limit)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $matches = $em->getRepository('ClubMatchBundle:Match')->getRecentMatches(null, $limit);

    return $this->render('ClubMatchBundle:League:RecentMatches.html.twig', array(
      'matches' => $matches
    ));
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $res = array();
    $form = $this->getForm($res);

    $sets = 5;
    for ($i = 0; $sets > $i; $i++) {
      $form = $form->add('user0set'.$i,'text', array(
        'label' => 'Set '.($i+1),
        'required' => false
      ));
      $form = $form->add('user1set'.$i,'text', array(
        'label' => 'Set '.($i+1),
        'required' => false
      ));
    }

    $form = $form->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {

        $this->get('club_match.match')->bindMatch($form->getData());

        if ($this->get('club_match.match')->isValid()) {
          $this->get('club_match.match')->save();
          $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
        } else {
          $this->get('session')->setFlash('error', $this->get('club_match.match')->getError());
        }
      }

      return $this->redirect($this->generateUrl('club_match_league_index'));
    }

    return array(
      'form' => $form->createView(),
      'sets' => $sets
    );
  }

  /**
   * @Route("/delete/{id}")
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

    return $this->redirect($this->generateUrl('club_match_league_index'));
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

  public function getForm($res)
  {
    $res['user0'] = $this->get('security.context')->getToken()->getUser()->getName();
    $res['user0_id'] = $this->get('security.context')->getToken()->getUser()->getId();

    $form = $this->createFormBuilder($res)
      ->add('user0_id', 'hidden')
      ->add('user1_id', 'hidden')
      ->add('user0', 'text')
      ->add('user1', 'text');

    return $form;
  }
}
