<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminTeamCategoryController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $teams = $em->getRepository('ClubTeamBundle:TeamCategory')->findAll();

    return array(
      'teams' => $teams
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $team = new \Club\TeamBundle\Entity\TeamCategory();

    $res = $this->process($team);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:TeamCategory',$id);

    $res = $this->process($team);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'team' => $team,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:TeamCategory',$this->getRequest()->get('id'));

    $em->remove($team);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminteamcategory_index'));
  }

  protected function process($team)
  {
    $form = $this->createForm(new \Club\TeamBundle\Form\TeamCategory(), $team);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($team);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_team_adminteamcategory_index'));
      }
    }

    return $form;
  }
}
