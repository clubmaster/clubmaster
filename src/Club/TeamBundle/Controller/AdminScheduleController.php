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
          $new_schedule = $sch;
          $sch->setSchedule(null);

          $repetition = $em->getRepository('ClubTeamBundle:Repetition')->findOneBy(array(
            'schedule' => $schedule->getId()
          ));
          $repetition->setSchedule($sch);
          $em->persist($repetition);
        } else {
          $sch->setSchedule($new_schedule);
        }

        $em->persist($new_schedule);
      }

      $em->remove($schedule);

    } elseif ($schedule->getSchedule() && count($schedule->getSchedule()->getSchedules())) {
      $em->remove($schedule);
    }

    $em->flush();
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
}
