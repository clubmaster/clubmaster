<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminRepetitionController extends Controller
{
  /**
   * @Route("/team/team/{team_id}/schedule/{schedule_id}/repetition")
   * @Template()
   */
  public function indexAction($team_id, $schedule_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $schedule_id);

    $parent = ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;
    $repetitions = $em->getRepository('ClubTeamBundle:Repetition')->findOneBy(array(
      'schedule' => $parent->getId()
    ));

    if (count($repetitions)) {
      return $this->redirect($this->generateUrl('club_team_adminrepetition_edit', array(
        'team_id' => $team_id,
        'schedule_id' => $schedule_id,
        'id' => $repetitions->getId()
      )));
    } else {
      return $this->redirect($this->generateUrl('club_team_adminrepetition_new', array(
        'team_id' => $team_id,
        'schedule_id' => $schedule_id
      )));
    }
  }

  /**
   * @Route("/team/team/{team_id}/schedule/{schedule_id}/repetition/new")
   * @Template()
   */
  public function newAction($team_id,$schedule_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $schedule_id);

    $repetition = new \Club\TeamBundle\Entity\Repetition();
    $repetition->setSchedule($schedule);
    $repetition->setFirstDate($schedule->getFirstDate());

    $schedule->setRepetition($repetition);

    $repetition->setType('daily');
    $form_daily = $this->createForm(new \Club\TeamBundle\Form\RepetitionDaily(), $repetition);
    if (($form_daily = $this->process($repetition, $form_daily)) instanceOf RedirectResponse) {
      $em->persist($schedule);
      return $form_daily;
    }

    $repetition->setType('weekly');
    $repetition->setDaysInWeek(array($schedule->getFirstDate()->format('N')));
    $form_weekly = $this->createForm(new \Club\TeamBundle\Form\RepetitionWeekly(), $repetition);
    if (($form_weekly = $this->process($repetition, $form_weekly)) instanceOf RedirectResponse) {
      $em->persist($schedule);
      return $form_weekly;
    }

    $repetition->setType('monthly');
    $form_monthly = $this->createForm(new \Club\TeamBundle\Form\RepetitionMonthly(), $repetition);
    if (($form_monthly = $this->process($repetition, $form_monthly)) instanceOf RedirectResponse) {
      $em->persist($schedule);
      return $form_monthly;
    }

    $repetition->setType('yearly');
    $form_yearly = $this->createForm(new \Club\TeamBundle\Form\RepetitionYearly(), $repetition);
    if (($form_yearly = $this->process($repetition, $form_yearly)) instanceOf RedirectResponse) {
      $em->persist($schedule);
      return $form_yearly;
    }

    return array(
      'schedule' => $schedule,
      'form_daily' => $form_daily->createView(),
      'form_weekly' => $form_weekly->createView(),
      'form_monthly' => $form_monthly->createView(),
      'form_yearly' => $form_yearly->createView()
    );
  }

  /**
   * @Route("/team/team/{team_id}/schedule/{schedule_id}/repetition/edit/{id}")
   * @Template()
   */
  public function editAction($team_id, $schedule_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $schedule = $em->find('ClubTeamBundle:Schedule', $schedule_id);
    $repetition = $em->find('ClubTeamBundle:Repetition', $id);

    if ($this->getRequest()->getMethod() == 'POST' && $repetition->getSchedule()->getId() != $schedule_id) {
      $repetition = new \Club\TeamBundle\Entity\Repetition();
      $repetition->setSchedule($schedule);
    }

    $repetition->setType('daily');
    $form_daily = $this->createForm(new \Club\TeamBundle\Form\RepetitionDaily(), $repetition);
    if (($form_daily = $this->process($repetition, $form_daily)) instanceOf RedirectResponse)
      return $form_daily;

    $repetition->setType('weekly');
    $form_weekly = $this->createForm(new \Club\TeamBundle\Form\RepetitionWeekly(), $repetition);
    if (($form_weekly = $this->process($repetition, $form_weekly)) instanceOf RedirectResponse)
      return $form_weekly;

    $repetition->setType('monthly');
    $form_monthly = $this->createForm(new \Club\TeamBundle\Form\RepetitionMonthly(), $repetition);
    if (($form_monthly = $this->process($repetition, $form_monthly)) instanceOf RedirectResponse)
      return $form_monthly;

    $repetition->setType('yearly');
    $form_yearly = $this->createForm(new \Club\TeamBundle\Form\RepetitionYearly(), $repetition);
    if (($form_yearly = $this->process($repetition, $form_yearly)) instanceOf RedirectResponse)
      return $form_yearly;

    return array(
      'repetition' => $repetition,
      'schedule' => $schedule,
      'form_daily' => $form_daily->createView(),
      'form_weekly' => $form_weekly->createView(),
      'form_monthly' => $form_monthly->createView(),
      'form_yearly' => $form_yearly->createView()
    );
  }

  /**
   * @Route("/team/team/{team_id}/schedule/{schedule_id}/repetition/edit/{id}/choice")
   * @Template()
   */
  public function editChoiceAction($team_id, $schedule_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repetition = $em->find('ClubTeamBundle:Repetition', $id);

    return array(
      'repetition' => $repetition
    );
  }

  /**
   * @Route("/team/team/{team_id}/schedule/{schedule_id}/repetition/edit/{id}/editfuture")
   * @Template()
   */
  public function editFutureAction($team_id, $schedule_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repetition = $em->find('ClubTeamBundle:Repetition', $id);

    return array(
      'repetition' => $repetition
    );
  }

  /**
   * @Route("/team/team/{team_id}/schedule/{schedule_id}/repetition/edit/{id}/editall")
   * @Template()
   */
  public function editAllAction($team_id, $schedule_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repetition = $em->find('ClubTeamBundle:Repetition', $id);
    $schedule = $em->find('ClubTeamBundle:Schedule', $schedule_id);

    $parent = ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;
    $old_rep = $parent->getRepetition();

    $parent->setRepetition(null);
    $em->persist($parent);
    $em->remove($old_rep);
    $em->flush();

    $parent->setRepetition($repetition);
    $repetition->setSchedule($parent);

    $em->persist($parent);
    $em->persist($repetition);

    $em->flush();

    return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
      'team_id' => $repetition->getSchedule()->getTeam()->getId()
    )));
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

  protected function process($repetition, $form)
  {
    if ($this->getRequest()->getMethod() == 'POST') {
      if ($this->getRequest()->get($form->getName()) != '') {
        $form->bindRequest($this->getRequest());
        if ($form->isValid()) {
          $em = $this->getDoctrine()->getEntityManager();
          $em->persist($repetition);
          $is_new = ($repetition->getId()) ? false : true;
          $em->flush();

          $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

          if ($is_new && !$repetition->getSchedule()->getSchedule()) {
            $event = new \Club\TeamBundle\Event\FilterRepetitionEvent($repetition);
            $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onRepetitionChange, $event);
          } elseif ($repetition->getSchedule()->getSchedule()) {

            return $this->redirect($this->generateUrl('club_team_adminrepetition_editchoice', array(
              'team_id' => $repetition->getSchedule()->getTeam()->getId(),
              'schedule_id' => $repetition->getSchedule()->getId(),
              'id' => $repetition->getId()
            )));
          }

          return $this->redirect($this->generateUrl('club_team_adminschedule_index', array(
            'team_id' => $repetition->getSchedule()->getTeam()->getId()
          )));
        }
      }
    }

    return $form;
  }
}
