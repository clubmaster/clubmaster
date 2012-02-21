<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminRepetitionController extends Controller
{
  /**
   * @Route("/team/team/{team_id}/team/{team_id}/repetition")
   * @Template()
   */
  public function indexAction($team_id, $team_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team', $team_id);

    $parent = ($team->getTeam()) ? $team->getTeam() : $team;
    $repetitions = $em->getRepository('ClubTeamBundle:Repetition')->findOneBy(array(
      'team' => $parent->getId()
    ));

    if (count($repetitions)) {
      return $this->redirect($this->generateUrl('club_team_adminrepetition_edit', array(
        'team_id' => $team_id,
        'team_id' => $team_id,
        'id' => $repetitions->getId()
      )));
    } else {
      return $this->redirect($this->generateUrl('club_team_adminrepetition_new', array(
        'team_id' => $team_id,
        'team_id' => $team_id
      )));
    }
  }

  /**
   * @Route("/team/team/{team_id}/team/{team_id}/repetition/new")
   * @Template()
   */
  public function newAction($team_id,$team_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team', $team_id);

    $repetition = new \Club\TeamBundle\Entity\Repetition();
    $repetition->setTeam($team);
    $repetition->setFirstDate($team->getFirstDate());

    $team->setRepetition($repetition);

    $repetition->setType('daily');
    $form_daily = $this->createForm(new \Club\TeamBundle\Form\RepetitionDaily(), $repetition);
    if (($form_daily = $this->process($repetition, $form_daily)) instanceOf RedirectResponse) {
      $em->persist($team);
      return $form_daily;
    }

    $repetition->setType('weekly');
    $repetition->setDaysInWeek(array($team->getFirstDate()->format('N')));
    $form_weekly = $this->createForm(new \Club\TeamBundle\Form\RepetitionWeekly(), $repetition);
    if (($form_weekly = $this->process($repetition, $form_weekly)) instanceOf RedirectResponse) {
      $em->persist($team);
      return $form_weekly;
    }

    $repetition->setType('monthly');
    $form_monthly = $this->createForm(new \Club\TeamBundle\Form\RepetitionMonthly(), $repetition);
    if (($form_monthly = $this->process($repetition, $form_monthly)) instanceOf RedirectResponse) {
      $em->persist($team);
      return $form_monthly;
    }

    $repetition->setType('yearly');
    $form_yearly = $this->createForm(new \Club\TeamBundle\Form\RepetitionYearly(), $repetition);
    if (($form_yearly = $this->process($repetition, $form_yearly)) instanceOf RedirectResponse) {
      $em->persist($team);
      return $form_yearly;
    }

    return array(
      'team' => $team,
      'form_daily' => $form_daily->createView(),
      'form_weekly' => $form_weekly->createView(),
      'form_monthly' => $form_monthly->createView(),
      'form_yearly' => $form_yearly->createView()
    );
  }

  /**
   * @Route("/team/team/{team_id}/team/{team_id}/repetition/edit/{id}")
   * @Template()
   */
  public function editAction($team_id, $team_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team', $team_id);
    $repetition = $em->find('ClubTeamBundle:Repetition', $id);

    if ($this->getRequest()->getMethod() == 'POST' && $repetition->getTeam()->getId() != $team_id) {
      $repetition = new \Club\TeamBundle\Entity\Repetition();
      $repetition->setTeam($team);
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
      'team' => $team,
      'form_daily' => $form_daily->createView(),
      'form_weekly' => $form_weekly->createView(),
      'form_monthly' => $form_monthly->createView(),
      'form_yearly' => $form_yearly->createView()
    );
  }

  /**
   * @Route("/team/team/{team_id}/team/{team_id}/repetition/edit/{id}/choice")
   * @Template()
   */
  public function editChoiceAction($team_id, $team_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repetition = $em->find('ClubTeamBundle:Repetition', $id);

    return array(
      'repetition' => $repetition
    );
  }

  /**
   * @Route("/team/team/{team_id}/team/{team_id}/repetition/edit/{id}/editfuture")
   * @Template()
   */
  public function editFutureAction($team_id, $team_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repetition = $em->find('ClubTeamBundle:Repetition',$id);
    $team = $repetition->getTeam();

    $parent = ($team->getTeam()) ? $team->getTeam() : $team;

    if (!count($em->getRepository('ClubTeamBundle:Team')->getAllPast($team))) {

      $this->changeParent($repetition);

    } else {
      $edit_parent = ($parent->getId() == $team->getId()) ? true : false;
      foreach ($em->getRepository('ClubTeamBundle:Team')->getAllFuture($team) as $sch) {
        if ($sch->getId() == $parent->getId())
          $edit_parent = true;
      }

      if ($edit_parent) {
        foreach ($em->getRepository('ClubTeamBundle:Team')->getAllPast($team) as $past) {
          if (!isset($new_parent)) {
            $new_parent = $this->copyParent($parent, $past);
            $new_parent->getRepetition()->setLastDate(new \DateTime($team->getFirstDate()->format('Y-m-d 00:00:00')));

            $em->persist($new_parent);
            $em->persist($new_parent->getRepetition());

          } else {
            $past->setTeam($new_parent);
          }
          $em->persist($past);

          $parent->getRepetition()->setFirstDate(new \DateTime($team->getFirstDate()->format('Y-m-d 00:00:00')));
          $em->persist($parent);

          $this->changeParent($repetition);
        }

      } else {
        foreach ($em->getRepository('ClubTeamBundle:Team')->getAllFuture($team) as $sch) {
          $sch->setTeam($team);
          $em->persist($sch);
        };

        $team->setRepetition($repetition);
        $team->setTeam(null);
        $parent->getRepetition()->setLastDate(new \DateTime($team->getFirstDate()->format('Y-m-d 00:00:00')));
        $team->getRepetition()->setFirstDate(new \DateTime($team->getFirstDate()->format('Y-m-d 00:00:00')));

        $em->persist($parent);
        $em->persist($team);
      }
    }

    $em->flush();
    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    $event = new \Club\TeamBundle\Event\FilterRepetitionEvent($repetition);
    $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onRepetitionChange, $event);

    return $this->redirect($this->generateUrl('club_team_adminteam_index', array(
      'team_id' => $team->getTeam()->getId()
    )));
  }

  private function changeParent(\Club\TeamBundle\Entity\Repetition $repetition)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $parent = ($repetition->getTeam()->getTeam()) ? $repetition->getTeam()->getTeam() : $repetition->getTeam();
    $old_rep = $parent->getRepetition();

    $parent->setRepetition(null);
    $em->persist($parent);
    $em->remove($old_rep);
    $em->flush();

    $parent->setRepetition($repetition);
    $repetition->setTeam($parent);

    $em->persist($parent);
    $em->persist($repetition);

    $em->flush();
  }

  /**
   * @Route("/team/team/{team_id}/team/{team_id}/repetition/edit/{id}/editall")
   * @Template()
   */
  public function editAllAction($team_id, $team_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repetition = $em->find('ClubTeamBundle:Repetition', $id);
    $team = $em->find('ClubTeamBundle:Team', $team_id);

    $this->changeParent($repetition);

    $event = new \Club\TeamBundle\Event\FilterRepetitionEvent($repetition);
    $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onRepetitionChange, $event);

    return $this->redirect($this->generateUrl('club_team_adminteam_index', array(
      'team_id' => $repetition->getTeam()->getTeam()->getId()
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

          $parent = ($repetition->getTeam()->getTeam()) ? $repetition->getTeam()->getTeam() : $repetition->getTeam();

          if (!count($parent->getTeams())) {
            $event = new \Club\TeamBundle\Event\FilterRepetitionEvent($repetition);
            $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onRepetitionChange, $event);
          } else {

            return $this->redirect($this->generateUrl('club_team_adminrepetition_editchoice', array(
              'team_id' => $repetition->getTeam()->getTeam()->getId(),
              'team_id' => $repetition->getTeam()->getId(),
              'id' => $repetition->getId()
            )));
          }

          return $this->redirect($this->generateUrl('club_team_adminteam_index', array(
            'team_id' => $repetition->getTeam()->getTeam()->getId()
          )));
        }
      }
    }

    return $form;
  }

  private function copyParent(\Club\TeamBundle\Entity\Team $old, \Club\TeamBundle\Entity\Team $team)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team->setTeam(null);

    $rep = new \Club\TeamBundle\Entity\Repetition();
    $rep->setType($old->getRepetition()->getType());
    $rep->setFirstDate($old->getRepetition()->getFirstDate());
    $rep->setLastDate($old->getRepetition()->getLastDate());
    $rep->setEndOccurrences($old->getRepetition()->getEndOccurrences());
    $rep->setRepeatEvery($old->getRepetition()->getRepeatEvery());
    $rep->setDaysInWeek($old->getRepetition()->getDaysInWeek());
    $rep->setDayOfMonth($old->getRepetition()->getDayOfMonth());
    $rep->setWeek($old->getRepetition()->getWeek());
    $rep->setTeam($team);
    $em->persist($rep);

    $team->setRepetition($rep);
    $em->persist($team);

    return $team;
  }
}
