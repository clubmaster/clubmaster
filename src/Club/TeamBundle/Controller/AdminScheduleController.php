<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class AdminScheduleController extends Controller
{
  /**
   * @Route("/team/team/{category_id}/schedule")
   * @Template()
   */
  public function indexAction($category_id)
  {
    $em = $this->getDoctrine()->getManager();

    $schedules = $em->getRepository('ClubTeamBundle:Schedule')->findBy(array(
      'team_category' => $category_id
    ), array(
      'first_date' => 'ASC'
    ));
    $category = $em->find('ClubTeamBundle:TeamCategory', $category_id);

    return array(
      'category' => $category,
      'schedules' => $schedules
    );
  }

  /**
   * @Route("/team/team/schedule/{schedule_id}/participant/{id}/unattend")
   * @Template()
   */
  public function unattendAction($schedule_id, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $schedule_id);
    $user = $em->find('ClubUserBundle:User', $id);

    $schedule->getUsers()->removeElement($user);
    $em->flush();

    $event = new \Club\TeamBundle\Event\FilterScheduleEvent($schedule, $user);
    $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onTeamUnattend, $event);

    $this->get('session')->getFlashBag()->add('notice', 'User has been deleted from the team.');

    return $this->redirect($this->generateUrl('club_team_adminschedule_participant', array(
      'id' => $schedule_id
    )));
  }

  /**
   * @Route("/team/team/schedule/{id}/participant")
   * @Template()
   */
  public function participantAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);

    return array(
      'team' => $schedule->getTeamCategory()->getId(),
      'schedule' => $schedule
    );
  }

  /**
   * @Route("/team/team/schedule/{id}/edit/choice")
   * @Template()
   */
  public function editChoiceAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);

    return array(
      'schedule' => $schedule
    );
  }

  /**
   * @Route("/team/team/schedule/{id}/delete/choice")
   * @Template()
   */
  public function deleteChoiceAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $id);

    return array(
      'schedule' => $schedule
    );
  }

  /**
   * @Route("/team/team/{category_id}/schedule/new")
   * @Template()
   */
  public function newAction($category_id)
  {
    $em = $this->getDoctrine()->getManager();
    $category = $em->find('ClubTeamBundle:TeamCategory', $category_id);

    $schedule = new \Club\TeamBundle\Entity\Schedule();
    $schedule->setTeamCategory($category);
    $schedule->setDescription($category->getDescription());
    $schedule->setPenalty($category->getPenalty());
    $schedule->setFirstDate(new \DateTime(date('Y-m-d 14:00:00')));
    $schedule->setEndDate(new \DateTime(date('Y-m-d 15:00:00')));
    $schedule->setMaxAttend(15);

    $res = $this->process($schedule);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'category' => $category,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/team/team/schedule/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    $res = $this->process($schedule);

    if ($this->getRequest()->getMethod() == 'POST') {
      if (count($schedule->getSchedules()) || $schedule->getSchedule())

        return $this->redirect($this->generateUrl('club_team_adminschedule_editchoice', array(
          'id' => $schedule->getId(),
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
   * @Route("/team/team/schedule/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    if ($schedule->getSchedule()) {
      if (count($schedule->getSchedule()->getSchedules())) {
        return $this->redirect($this->generateUrl('club_team_adminschedule_deletechoice', array(
          'id' => $id
        )));
      }
    }

    if (count($schedule->getSchedules()))

      return $this->redirect($this->generateUrl('club_team_adminschedule_deletechoice', array(
        'id' => $id
      )));

    $em->remove($schedule);
    $em->flush();

    $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'category_id' => $schedule->getTeamCategory()->getId()
    )));
  }

  /**
   * @Route("/team/team/schedule/delete/{id}/once")
   */
  public function deleteOnceAction($id)
  {
    $em = $this->getDoctrine()->getManager();
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
    $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'category_id' => $schedule->getTeamCategory()->getId()
    )));
  }

  /**
   * @Route("/team/team/schedule/delete/{id}/future")
   */
  public function deleteFutureAction($id)
  {
    $em = $this->getDoctrine()->getManager();
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

      $em->flush();
    }

    $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'category_id' => $schedule->getTeamCategory()->getId()
    )));
  }

  /**
   * @Route("/team/team/schedule/delete/{id}/all")
   */
  public function deleteAllAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    $parent = $this->getParent($schedule);
    $this->deleteAll($parent);

    $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'category_id' => $schedule->getTeamCategory()->getId()
    )));
  }

  /**
   * @Route("/team/team/schedule/edit/{id}/future")
   */
  public function editFutureAction($id)
  {
    $em = $this->getDoctrine()->getManager();
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
            $new_parent->getRepetition()->setLastDate(new \DateTime($schedule->getFirstDate()->format('Y-m-d 00:00:00')));
            $em->persist($new_parent);

          } else {
            $past->setSchedule($new_parent);
          }
          $em->persist($past);

          $parent->getRepetition()->setFirstDate(new \DateTime($schedule->getFirstDate()->format('Y-m-d 00:00:00')));
          $em->persist($parent);
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
        $parent->getRepetition()->setLastDate(new \DateTime($schedule->getFirstDate()->format('Y-m-d 00:00:00')));
        $schedule->getRepetition()->setFirstDate(new \DateTime($schedule->getFirstDate()->format('Y-m-d 00:00:00')));

        $em->persist($parent);
        $em->persist($schedule);
      }
    }

    $em->flush();
    $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'category_id' => $schedule->getTeamCategory()->getId()
    )));
  }

  /**
   * @Route("/team/team/schedule/edit/{id}/all")
   */
  public function editAllAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $schedule = $em->find('ClubTeamBundle:Schedule',$id);

    $parent = $this->getParent($schedule);
    $this->updateSchedule($parent, $schedule);

    foreach ($parent->getSchedules() as $sch) {
      $this->updateSchedule($sch, $schedule);
    }

    $em->flush();
    $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'category_id' => $schedule->getTeamCategory()->getId()
    )));
  }

  /**
   * This first parameter is to be updated be parameter two
   */
  protected function updateSchedule(\Club\TeamBundle\Entity\Schedule $schedule, \Club\TeamBundle\Entity\Schedule $original)
  {
    if( $schedule == $original)

      return;

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

    $em = $this->getDoctrine()->getManager();

    $schedule->resetInstructors();

    $schedule->setDescription($original->getDescription());
    $schedule->setFirstDate(new \DateTime($schedule->getFirstDate()->sub($diff_first)->format('Y-m-d H:i:s')));
    $schedule->setEndDate(new \DateTime($schedule->getEndDate()->sub($diff_end)->format('Y-m-d H:i:s')));
    $schedule->setLevel($original->getLevel());
    $schedule->setLocation($original->getLocation());
    $schedule->setMaxAttend($original->getMaxAttend());
    $schedule->setPenalty($original->getPenalty());

    foreach ($original->getInstructors() as $instructor) {
      $schedule->addInstructor($instructor);
    }

    foreach ($original->getFields() as $field) {
      $schedule->addField($field);
    }

    $em->persist($schedule);
  }

  protected function process($schedule)
  {
    $form = $this->createForm(new \Club\TeamBundle\Form\Schedule(), $schedule);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($schedule);
        $em->flush();

        $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
          'category_id' => $schedule->getTeamCategory()->getId()
        )));
      }
    }

    return $form;
  }

  private function promoteParent(\Club\TeamBundle\Entity\Schedule $old_parent, \Club\TeamBundle\Entity\Schedule $schedule)
  {
    $em = $this->getDoctrine()->getManager();

    $schedule->setSchedule(null);

    $repetition = $em->getRepository('ClubTeamBundle:Repetition')->findOneBy(array(
      'schedule' => $old_parent->getId()
    ));
    $repetition->setSchedule($schedule);
    $em->persist($repetition);

    return $schedule;
  }

  private function copyParent(\Club\TeamBundle\Entity\Schedule $old, \Club\TeamBundle\Entity\Schedule $schedule)
  {
    $em = $this->getDoctrine()->getManager();
    $schedule->setSchedule(null);

    $rep = new \Club\TeamBundle\Entity\Repetition();
    $rep->setType($old->getRepetition()->getType());
    $rep->setFirstDate($old->getRepetition()->getFirstDate());
    $rep->setLastDate($old->getRepetition()->getLastDate());
    $rep->setEndOccurrences($old->getRepetition()->getEndOccurrences());
    $rep->setRepeatEvery($old->getRepetition()->getRepeatEvery());
    $rep->setDaysInWeek($old->getRepetition()->getDaysInWeek());
    $rep->setDayOfMonth($old->getRepetition()->getDayOfMonth());
    $rep->setWeek($old->getRepetition()->getWeek());
    $rep->setSchedule($schedule);
    $em->persist($rep);

    $schedule->setRepetition($rep);
    $em->persist($schedule);

    return $schedule;
  }

  protected function getParent(\Club\TeamBundle\Entity\Schedule $schedule)
  {
    return ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;
  }

  protected function deleteAll(\Club\TeamBundle\Entity\Schedule $schedule)
  {
    $em = $this->getDoctrine()->getManager();

    $parent = ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;
    $repetition = $parent->getRepetition();
    $repetition->setSchedule(null);

    $em->persist($repetition);
    $em->flush();

    $em->createQueryBuilder()
      ->delete('ClubTeamBundle:Schedule','s')
      ->where('(s.id = :id OR s.schedule = :id)')
      ->setParameter('id', $parent->getId())
      ->getQuery()
      ->execute();

    $em->remove($repetition);
    $em->flush();

    return true;
  }
}
