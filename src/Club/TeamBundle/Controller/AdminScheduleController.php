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
   * @Route("/team/team/{team_id}/schedule/{id}/edit/choice")
   * @Template()
   */
  public function editChoiceAction($team_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);

    return array(
      'schedule' => $schedule
    );
  }

  /**
   * @Route("/team/team/{team_id}/schedule/{id}/delete/choice")
   * @Template()
   */
  public function deleteChoiceAction($team_id,$id)
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
    $schedule->setMaxAttend(15);

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

    if ($this->getRequest()->getMethod() == 'POST') {
      if (count($schedule->getSchedules()) || $schedule->getSchedule())
        return $this->redirect($this->generateUrl('club_team_adminschedule_editchoice', array(
          'id' => $schedule->getId(),
          'team_id' => $schedule->getTeam()->getId()
        )));
    }

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
        return $this->redirect($this->generateUrl('club_team_adminschedule_deletechoice', array(
          'team_id' => $team_id,
          'id' => $id
        )));
      }
    }

    if (count($schedule->getSchedules()))
      return $this->redirect($this->generateUrl('club_team_adminschedule_deletechoice', array(
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

  /**
   * @Route("/team/team/{team_id}/schedule/edit/{id}/future")
   */
  public function editFutureAction($team_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    $parent = $this->getParent($schedule);

    if (!count($em->getRepository('ClubTeamBundle:Schedule')->getAllPast($schedule))) {
      $this->updateSchedule($parent, $schedule);

      foreach ($parent->getSchedules() as $sch) {
        $this->updateSchedule($sch, $schedule);
      }

    } else {
      $edit_parent = ($parent->getId() == $schedule->getId()) ? true : false;
      foreach ($em->getRepository('ClubTeamBundle:Schedule')->getAllFuture($schedule) as $sch) {
        if ($sch->getId() == $parent->getId())
          $edit_parent = true;
      }

      if ($edit_parent) {
        foreach ($em->getRepository('ClubTeamBundle:Schedule')->getAllPast($schedule) as $past) {
          if (!isset($new_parent)) {
            $new_parent = $this->copyParent($parent, $past);
          } else {
            $past->setSchedule($new_parent);
          }

          $em->persist($past);
        }

        foreach ($em->getRepository('ClubTeamBundle:Schedule')->getAllFuture($schedule) as $sch) {
          $this->updateSchedule($sch, $schedule);
        };

      } else {
        foreach ($em->getRepository('ClubTeamBundle:Schedule')->getAllFuture($schedule) as $sch) {
          $this->updateSchedule($sch, $schedule);
          $sch->setSchedule($schedule);
        };

        $schedule = $this->copyParent($parent, $schedule);
        $em->persist($schedule);
      }
    }

    $em->flush();
    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'team_id' => $schedule->getTeam()->getId()
    )));
  }

  /**
   * @Route("/team/team/{team_id}/schedule/edit/{id}/all")
   */
  public function editAllAction($team_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    $parent = $this->getParent($schedule);
    $this->updateSchedule($parent, $schedule);

    foreach ($parent->getSchedules() as $sch) {
      $this->updateSchedule($sch, $schedule);
    }

    $em->flush();
    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'team_id' => $schedule->getTeam()->getId()
    )));
  }

  /**
   * This first parameter is to be updated be parameter two
   */
  protected function updateSchedule(\Club\TeamBundle\Entity\Schedule $schedule, \Club\TeamBundle\Entity\Schedule $original)
  {
    $t1_first = new \DateTime(
      '@'.mktime(
      $original->getFirstDate()->format('H'),
      $original->getFirstDate()->format('i'),
      $original->getFirstDate()->format('s'),
      1,1,1970));
    $t2_first = new \DateTime(
      '@'.mktime(
      $schedule->getFirstDate()->format('H'),
      $schedule->getFirstDate()->format('i'),
      $schedule->getFirstDate()->format('s'),
      1,1,1970));

    $t1_end = new \DateTime(
      '@'.mktime(
      $original->getEndDate()->format('H'),
      $original->getEndDate()->format('i'),
      $original->getEndDate()->format('s'),
      1,1,1970));
    $t2_end = new \DateTime(
      '@'.mktime(
      $schedule->getEndDate()->format('H'),
      $schedule->getEndDate()->format('i'),
      $schedule->getEndDate()->format('s'),
      1,1,1970));

    $diff_first = $t1_first->diff($t2_first);
    $diff_end = $t1_end->diff($t2_end);

    $em = $this->getDoctrine()->getEntityManager();

    $schedule->setDescription($original->getDescription());
    $schedule->setFirstDate(new \DateTime($schedule->getFirstDate()->sub($diff_first)->format('Y-m-d H:i:s')));
    $schedule->setEndDate(new \DateTime($schedule->getEndDate()->sub($diff_end)->format('Y-m-d H:i:s')));
    $schedule->setLevel($original->getLevel());
    $schedule->setLocation($original->getLocation());
    $schedule->setMaxAttend($original->getMaxAttend());

    $em->persist($schedule);
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

  private function copyParent(\Club\TeamBundle\Entity\Schedule $old_parent, \Club\TeamBundle\Entity\Schedule $schedule)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $schedule->setSchedule(null);

    $repetition = $em->getRepository('ClubTeamBundle:Repetition')->findOneBy(array(
      'schedule' => $old_parent->getId()
    ));
    $rep = new \Club\TeamBundle\Entity\Repetition();
    $rep->setType($repetition->getType());
    $rep->setFirstDate($repetition->getFirstDate());
    $rep->setLastDate($repetition->getLastDate());
    $rep->setEndOccurrences($repetition->getEndOccurrences());
    $rep->setRepeatEvery($repetition->getRepeatEvery());
    $rep->setDaysInWeek($repetition->getDaysInWeek());
    $rep->setDayOfMonth($repetition->getDayOfMonth());
    $rep->setWeek($repetition->getWeek());
    $rep->setSchedule($schedule);

    $em->persist($rep);

    return $schedule;
  }

  protected function getParent(\Club\TeamBundle\Entity\Schedule $schedule)
  {
    return ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;
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
