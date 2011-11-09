<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminScheduleController extends Controller
{
  /**
   * @Route("/team/team/{team_id}/schedule")
   * @Template()
   */
  public function indexAction($team_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedules = $em->getRepository('ClubTeamBundle:Schedule')->findBy(array(
      'team' => $team_id
    ), array(
      'first_date' => 'ASC'
    ));
    $team = $em->find('ClubTeamBundle:Team', $team_id);

    return array(
      'team' => $team,
      'schedules' => $schedules
    );
  }

  /**
   * @Route("/team/team/{team_id}/schedule/{id}/choice")
   * @Template()
   */
  public function choiceAction($team_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);

    return array(
      'schedule' => $schedule
    );
  }

  /**
   * @Route("/team/team/{team_id}/schedule/new")
   * @Template()
   */
  public function newAction($team_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $team = $em->find('ClubTeamBundle:Team', $team_id);
    $schedule = new \Club\TeamBundle\Entity\Schedule();
    $schedule->setTeam($team);
    $schedule->setFirstDate(new \DateTime());
    $schedule->setEndDate(new \DateTime());

    $res = $this->process($schedule);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'team' => $team,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/team/{team_id}/schedule/edit/{id}")
   * @Template()
   */
  public function editAction($team_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$team_id);
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    $res = $this->process($schedule);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'schedule' => $schedule,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/team/{team_id}/schedule/delete/{id}")
   */
  public function deleteAction($team_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    if ($schedule->getSchedule()) {
      if (count($schedule->getSchedule()->getSchedules())) {
        return $this->redirect($this->generateUrl('club_team_adminschedule_choice', array(
          'team_id' => $team_id,
          'id' => $id
        )));
      }
    }

    if (count($schedule->getSchedules()))
      return $this->redirect($this->generateUrl('club_team_adminschedule_choice', array(
        'team_id' => $team_id,
        'id' => $id
      )));

    $em->remove($schedule);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'team_id' => $schedule->getTeam()->getId()
    )));
  }

  /**
   * @Route("/team/team/{team_id}/schedule/delete/{id}/once")
   */
  public function deleteOnceAction($team_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    if (count($schedule->getSchedules())) {
      foreach ($schedule->getSchedules() as $sch) {
        if (!isset($new_schedule)) {
          $new_schedule = $this->promoteParent($schedule, $sch);
        } else {
          $sch->setSchedule($new_schedule);
        }

        $em->persist($sch);
      }

      $em->remove($schedule);

    } elseif ($schedule->getSchedule()) {
      $em->remove($schedule);
    }

    $em->flush();
    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'team_id' => $schedule->getTeam()->getId()
    )));
  }

  /**
   * @Route("/team/team/{team_id}/schedule/delete/{id}/future")
   */
  public function deleteFutureAction($team_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    $parent = $this->getParent($schedule);

    if (!count($em->getRepository('ClubTeamBundle:Schedule')->getAllPast($schedule))) {
      $this->deleteAll($parent);
    } else {
      $delete_parent = false;
      foreach ($em->getRepository('ClubTeamBundle:Schedule')->getAllFuture($schedule) as $sch) {
        if ($sch->getId() == $parent->getId())
          $delete_parent = true;
      }

      if ($delete_parent) {
        foreach ($em->getRepository('ClubTeamBundle:Schedule')->getAllPast($schedule) as $past) {
          if (!isset($new_parent)) {
            $new_parent = $this->promoteParent($parent, $past);
          } else {
            $past->setSchedule($new_parent);
          }

          $em->persist($past);
        }
      }

      foreach ($em->getRepository('ClubTeamBundle:Schedule')->getAllFuture($schedule) as $sch) {
        $em->remove($sch);
      };
    }

    $em->flush();
    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'team_id' => $schedule->getTeam()->getId()
    )));
  }

  /**
   * @Route("/team/team/{team_id}/schedule/delete/{id}/all")
   */
  public function deleteAllAction($team_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    $parent = $this->getParent($schedule);
    $this->deleteAll($parent);

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'team_id' => $schedule->getTeam()->getId()
    )));
  }

  protected function process($schedule)
  {
    $form = $this->createForm(new \Club\TeamBundle\Form\Schedule(), $schedule);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($schedule);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
          'team_id' => $schedule->getTeam()->getId()
        )));
      }
    }

    return $form;
  }

  private function promoteParent(\Club\TeamBundle\Entity\Schedule $old_parent, \Club\TeamBundle\Entity\Schedule $schedule)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $schedule->setSchedule(null);

    $repetition = $em->getRepository('ClubTeamBundle:Repetition')->findOneBy(array(
      'schedule' => $old_parent->getId()
    ));
    $repetition->setSchedule($schedule);
    $em->persist($repetition);

    return $schedule;
  }

  protected function getParent(\Club\TeamBundle\Entity\Schedule $schedule)
  {
    if ($schedule->getSchedule()) {
      $parent = $schedule->getSchedule();
    } else {
      $parent = $schedule;
    }

    return $parent;
  }

  protected function deleteAll(\Club\TeamBundle\Entity\Schedule $schedule)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $em->createQueryBuilder()
      ->delete('ClubTeamBundle:Schedule','s')
      ->where('s.id = :id')
      ->setParameter('id', $schedule->getId())
      ->getQuery()
      ->getResult();

    return true;
  }
}
