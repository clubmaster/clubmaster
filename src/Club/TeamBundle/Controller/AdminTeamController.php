<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminTeamController extends Controller
{
  /**
   * @Route("/team/team")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $teams = $em->getRepository('ClubTeamBundle:Team')->getByDate($calendar_date);

    return array(
      'teams' => $teams
    );
  }

  /**
   * @Route("/team/team/new")
   * @Template()
   */
  public function newAction()
  {
    $team = new \Club\TeamBundle\Entity\Team();

    $res = $this->process($team);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/team/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$id);

    $res = $this->process($team);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'team' => $team,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/team/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$this->getRequest()->get('id'));

    $em->remove($team);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_team_team'));
  }

  protected function process($team)
  {
    $form = $this->createForm(new \Club\TeamBundle\Form\Team(), $team);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($team);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_team_team'));
      }
    }

    return $form;
  }
}
