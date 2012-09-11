<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class AdminLevelController extends Controller
{
  /**
   * @Route("/team/level")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $levels = $em->getRepository('ClubTeamBundle:Level')->findAll();

    return array(
      'levels' => $levels
    );
  }

  /**
   * @Route("/team/level/new")
   * @Template()
   */
  public function newAction()
  {
    $level = new \Club\TeamBundle\Entity\Level();

    $res = $this->process($level);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/level/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $level = $em->find('ClubTeamBundle:Level',$id);

    $res = $this->process($level);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'level' => $level,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/level/delete/{id}")
   */
  public function deleteAction($id)
  {
    try {
      $em = $this->getDoctrine()->getEntityManager();
      $level = $em->find('ClubTeamBundle:Level',$this->getRequest()->get('id'));

      $em->remove($level);
      $em->flush();

      $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    } catch (\PDOException $e) {
      $this->get('session')->setFlash('error', $this->get('translator')->trans('You cannot delete level which is already being used.'));
    }

    return $this->redirect($this->generateUrl('club_team_adminlevel_index'));
  }

  protected function process($level)
  {
    $form = $this->createForm(new \Club\TeamBundle\Form\Level(), $level);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($level);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_team_adminlevel_index'));
      }
    }

    return $form;
  }
}
