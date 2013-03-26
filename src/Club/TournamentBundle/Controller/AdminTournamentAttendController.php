<?php

namespace Club\TournamentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/tournament/attend")
 */
class AdminTournamentAttendController extends Controller
{
  /**
   * @Route("/new/{tournament_id}")
   * @Template()
   */
  public function newAction($tournament_id)
  {
    $em = $this->getDoctrine()->getManager();

    $res = array();
    $form = $this->getForm($res);

    $form->bind($this->getRequest());
    if ($form->isValid()) {
      try {
        $res = $form->getData();
        $user = $em->find('ClubUserBundle:User', $res['user_id']);
        if (!$user)
          $user = $em->getRepository('ClubUserBundle:User')->getOneBySearch(array('query' => $res['user']));
        if (!$user)
          throw new \Exception($this->get('translator')->trans('No such user'));

        $tournament = $em->find('ClubTournamentBundle:Tournament', $tournament_id);
        $t = $this->get('club_tournament.tournament')
          ->bindUser($tournament, $user)
          ->validate()
          ->save();

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));
      } catch (\Exception $e) {
        $this->get('session')->setFlash('error', $this->get('translator')->trans($e->getMessage()));
      }
    }

    return $this->redirect($this->generateUrl('club_tournament_admintournamentattend_index', array(
      'tournament_id' => $tournament_id
    )));
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction(\Club\TournamentBundle\Entity\Attend $attend)
  {
    $form = $this->createForm(new \Club\TournamentBundle\Form\Attend, $attend);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($attend);
        $em->flush();

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_tournament_admintournamentattend_index', array(
          'tournament_id' => $attend->getTournament()->getId()
        )));
      }
    }

    return array(
      'attend' => $attend,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/delete//{id}")
   */
  public function deleteAction(\Club\TournamentBundle\Entity\Attend $attend)
  {
    $em = $this->getDoctrine()->getManager();

    $em->remove($attend);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_tournament_admintournamentattend_index', array(
      'tournament_id' => $attend->getTournament()->getId()
    )));
  }

  /**
   * @Route("/{tournament_id}")
   * @Template()
   */
  public function indexAction($tournament_id)
  {
    $em = $this->getDoctrine()->getManager();
    $tournament = $em->find('ClubTournamentBundle:Tournament', $tournament_id);
    $attends = $em->getRepository('ClubTournamentBundle:Attend')->getSeeds($tournament);

    $res = array();
    $form = $this->getForm($res);

    return array(
      'tournament' => $tournament,
      'attends' => $attends,
      'form' => $form->createView()
    );
  }

  protected function getForm($res)
  {
    $form = $this->createFormBuilder($res)
      ->add('user', 'text', array(
        'label' => 'Player'
      ))
      ->add('user_id', 'hidden')
      ->getForm();

    return $form;
  }
}
