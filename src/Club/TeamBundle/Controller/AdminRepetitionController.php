<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminRepetitionController extends Controller
{
  /**
   * @Route("/team/team/{team_id}/repetition")
   * @Template()
   */
  public function indexAction($team_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repetitions = $em->getRepository('ClubTeamBundle:Repetition')->findBy(array(
      'team' => $team_id
    ));

    return array(
      'repetitions' => $repetitions
    );
  }

  /**
   * @Route("/team/team/{team_id}/repetition/new")
   * @Template()
   */
  public function newAction($team_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team', $team_id);

    $repetition = new \Club\TeamBundle\Entity\Repetition();
    $repetition->setTeam($team);

    $res = $this->process($repetition);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/team/{team_id}/edit/{id}")
   * @Template()
   */
  public function editAction($team_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repetition = $em->find('ClubTeamBundle:Repetition',$id);

    $res = $this->process($repetition);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'repetition' => $repetition,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/team/{team_id}/delete/{id}")
   */
  public function deleteAction($team_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repetition = $em->find('ClubTeamBundle:Repetition',$this->getRequest()->get('id'));

    $em->remove($repetition);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminrepetition_index', array(
      'team_id' => $repetition->getTeam()->getId()
    )));
  }

  protected function process($repetition)
  {
    $form = $this->createForm(new \Club\TeamBundle\Form\Repetition(), $repetition);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($repetition);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_team_adminrepetition_index', array(
          'team_id' => $repetition->getTeam()->getId()
        )));
      }
    }

    return $form;
  }
}
