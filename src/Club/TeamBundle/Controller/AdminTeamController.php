<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminTeamController extends Controller
{
  /**
   * @Route("/{team_category_id}/team")
   * @Template()
   */
  public function indexAction($team_category_id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $teams = $em->getRepository('ClubTeamBundle:Team')->findBy(array(
      'team_category' => $team_category_id
    ), array(
      'first_date' => 'ASC'
    ));
    $team_category = $em->find('ClubTeamBundle:TeamCategory', $team_category_id);

    return array(
      'team_category' => $team_category,
      'teams' => $teams
    );
  }

  /**
   * @Route("/{team_category_id}/team/{team_id}/participant/{id}/unattend")
   * @Template()
   */
  public function unattendAction($team_category_id, $team_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team', $team_id);
    $user = $em->find('ClubUserBundle:User', $id);

    $team->getUsers()->removeElement($user);
    $em->flush();

    $event = new \Club\TeamBundle\Event\FilterTeamEvent($team, $user);
    $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onTeamUnattend, $event);

    $this->get('session')->setFlash('notice', 'User has been deleted from the team.');

    return $this->redirect($this->generateUrl('club_team_adminteam_participant', array(
      'team_id' => $team_id,
      'id' => $team_id
    )));
  }

  /**
   * @Route("/{team_category_id}/team/{id}/participant")
   * @Template()
   */
  public function participantAction($team_category_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team', $id);

    return array(
      'team_category' => $team->getTeamCategory(),
      'team' => $team
    );
  }

  /**
   * @Route("/{team_category_id}/team/{id}/edit/choice")
   * @Template()
   */
  public function editChoiceAction($team_category_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team', $id);

    return array(
      'team' => $team
    );
  }

  /**
   * @Route("/{team_category_id}/team/{id}/delete/choice")
   * @Template()
   */
  public function deleteChoiceAction($team_category_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team', $id);

    return array(
      'team' => $team
    );
  }

  /**
   * @Route("/{team_category_id}/team/new")
   * @Template()
   */
  public function newAction($team_category_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team_category = $em->find('ClubTeamBundle:TeamCategory', $team_category_id);

    $team = new \Club\TeamBundle\Entity\Team();
    $team->setTeamCategory($team_category);
    $team->setFirstDate(new \DateTime(date('Y-m-d 14:00:00')));
    $team->setEndDate(new \DateTime(date('Y-m-d 15:00:00')));
    $team->setMaxAttend(15);

    $res = $this->process($team);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'team_category' => $team_category,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/{team_category_id}/team/edit/{id}")
   * @Template()
   */
  public function editAction($team_category_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$team_id);
    $team = $em->find('ClubTeamBundle:Team',$id);

    $res = $this->process($team);

    if ($this->getRequest()->getMethod() == 'POST') {
      if (count($team->getTeams()) || $team->getTeam())
        return $this->redirect($this->generateUrl('club_team_adminteam_editchoice', array(
          'id' => $team->getId(),
          'team_id' => $team->getTeam()->getId()
        )));
    }

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'team' => $team,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/{team_category_id}/team/delete/{id}")
   */
  public function deleteAction($team_category_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$id);

    if ($team->getTeam()) {
      if (count($team->getTeam()->getTeams())) {
        return $this->redirect($this->generateUrl('club_team_adminteam_deletechoice', array(
          'team_id' => $team_id,
          'id' => $id
        )));
      }
    }

    if (count($team->getTeams()))
      return $this->redirect($this->generateUrl('club_team_adminteam_deletechoice', array(
        'team_id' => $team_id,
        'id' => $id
      )));

    $em->remove($team);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminteam_index', array(
      'team_id' => $team->getTeam()->getId()
    )));
  }

  /**
   * @Route("/{team_category_id}/team/delete/{id}/once")
   */
  public function deleteOnceAction($team_category_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$id);

    if (count($team->getTeams())) {
      foreach ($team->getTeams() as $sch) {
        if (!isset($new_team)) {
          $new_team = $this->promoteParent($team, $sch);
        } else {
          $sch->setTeam($new_team);
        }

        $em->persist($sch);
      }

      $em->remove($team);

    } elseif ($team->getTeam()) {
      $em->remove($team);
    }

    $em->flush();
    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminteam_index', array(
      'team_id' => $team->getTeam()->getId()
    )));
  }

  /**
   * @Route("/{team_category_id}/team/delete/{id}/future")
   */
  public function deleteFutureAction($team_category_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$id);

    $parent = $this->getParent($team);

    if (!count($em->getRepository('ClubTeamBundle:Team')->getAllPast($team))) {
      $this->deleteAll($parent);
    } else {
      $delete_parent = false;
      foreach ($em->getRepository('ClubTeamBundle:Team')->getAllFuture($team) as $sch) {
        if ($sch->getId() == $parent->getId())
          $delete_parent = true;
      }

      if ($delete_parent) {
        foreach ($em->getRepository('ClubTeamBundle:Team')->getAllPast($team) as $past) {
          if (!isset($new_parent)) {
            $new_parent = $this->promoteParent($parent, $past);
          } else {
            $past->setTeam($new_parent);
          }

          $em->persist($past);
        }
      }

      foreach ($em->getRepository('ClubTeamBundle:Team')->getAllFuture($team) as $sch) {
        $em->remove($sch);
      };

      $em->flush();
    }

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminteam_index', array(
      'team_id' => $team->getTeam()->getId()
    )));
  }

  /**
   * @Route("/{team_category_id}/team/delete/{id}/all")
   */
  public function deleteAllAction($team_category_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$id);

    $parent = $this->getParent($team);
    $this->deleteAll($parent);

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminteam_index', array(
      'team_id' => $team->getTeam()->getId()
    )));
  }

  /**
   * @Route("/{team_category_id}/team/edit/{id}/future")
   */
  public function editFutureAction($team_category_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$id);

    $parent = $this->getParent($team);

    if (!count($em->getRepository('ClubTeamBundle:Team')->getAllPast($team))) {
      $this->updateTeam($parent, $team);

      foreach ($parent->getTeams() as $sch) {
        $this->updateTeam($sch, $team);
      }

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

          } else {
            $past->setTeam($new_parent);
          }
          $em->persist($past);

          $parent->getRepetition()->setFirstDate(new \DateTime($team->getFirstDate()->format('Y-m-d 00:00:00')));
          $em->persist($parent);
        }

        foreach ($em->getRepository('ClubTeamBundle:Team')->getAllFuture($team) as $sch) {
          $this->updateTeam($sch, $team);
        };

      } else {
        foreach ($em->getRepository('ClubTeamBundle:Team')->getAllFuture($team) as $sch) {
          $this->updateTeam($sch, $team);
          $sch->setTeam($team);
        };

        $team = $this->copyParent($parent, $team);
        $parent->getRepetition()->setLastDate(new \DateTime($team->getFirstDate()->format('Y-m-d 00:00:00')));
        $team->getRepetition()->setFirstDate(new \DateTime($team->getFirstDate()->format('Y-m-d 00:00:00')));

        $em->persist($parent);
        $em->persist($team);
      }
    }

    $em->flush();
    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminteam_index', array(
      'team_id' => $team->getTeam()->getId()
    )));
  }

  /**
   * @Route("/{team_category_id}/team/edit/{id}/all")
   */
  public function editAllAction($team_category_id,$id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $team = $em->find('ClubTeamBundle:Team',$id);

    $parent = $this->getParent($team);
    $this->updateTeam($parent, $team);

    foreach ($parent->getTeams() as $sch) {
      $this->updateTeam($sch, $team);
    }

    $em->flush();
    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_team_adminteam_index', array(
      'team_id' => $team->getTeam()->getId()
    )));
  }

  /**
   * This first parameter is to be updated be parameter two
   */
  protected function updateTeam(\Club\TeamBundle\Entity\Team $team, \Club\TeamBundle\Entity\Team $original)
  {
    if( $team == $original)
      return;

    $t1_first = new \DateTime(
      '@'.mktime(
      $original->getFirstDate()->format('H'),
      $original->getFirstDate()->format('i'),
      $original->getFirstDate()->format('s'),
      1,1,1970));
    $t2_first = new \DateTime(
      '@'.mktime(
      $team->getFirstDate()->format('H'),
      $team->getFirstDate()->format('i'),
      $team->getFirstDate()->format('s'),
      1,1,1970));

    $t1_end = new \DateTime(
      '@'.mktime(
      $original->getEndDate()->format('H'),
      $original->getEndDate()->format('i'),
      $original->getEndDate()->format('s'),
      1,1,1970));
    $t2_end = new \DateTime(
      '@'.mktime(
      $team->getEndDate()->format('H'),
      $team->getEndDate()->format('i'),
      $team->getEndDate()->format('s'),
      1,1,1970));

    $diff_first = $t1_first->diff($t2_first);
    $diff_end = $t1_end->diff($t2_end);

    $em = $this->getDoctrine()->getEntityManager();

    $team->resetInstructors();

    $team->setDescription($original->getDescription());
    $team->setFirstDate(new \DateTime($team->getFirstDate()->sub($diff_first)->format('Y-m-d H:i:s')));
    $team->setEndDate(new \DateTime($team->getEndDate()->sub($diff_end)->format('Y-m-d H:i:s')));
    $team->setLevel($original->getLevel());
    $team->setLocation($original->getLocation());
    $team->setMaxAttend($original->getMaxAttend());
    $team->setPenalty($original->getPenalty());

    foreach ($original->getInstructors() as $instructor) {
      $team->addInstructor($instructor);
    }

    foreach ($original->getFields() as $field) {
      $team->addField($field);
    }

    $em->persist($team);
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

        return $this->redirect($this->generateUrl('club_team_adminteam_index', array(
          'team_category_id' => $team->getTeamCategory()->getId()
        )));
      }
    }

    return $form;
  }

  private function promoteParent(\Club\TeamBundle\Entity\Team $old_parent, \Club\TeamBundle\Entity\Team $team)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $team->setTeam(null);

    $repetition = $em->getRepository('ClubTeamBundle:Repetition')->findOneBy(array(
      'team' => $old_parent->getId()
    ));
    $repetition->setTeam($team);
    $em->persist($repetition);

    return $team;
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

  protected function getParent(\Club\TeamBundle\Entity\Team $team)
  {
    return ($team->getTeam()) ? $team->getTeam() : $team;
  }

  protected function deleteAll(\Club\TeamBundle\Entity\Team $team)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $parent = ($team->getTeam()) ? $team->getTeam() : $team;
    $repetition = $parent->getRepetition();
    $repetition->setTeam(null);

    $em->persist($repetition);
    $em->flush();

    $em->createQueryBuilder()
      ->delete('ClubTeamBundle:Team','s')
      ->where('(s.id = :id OR s.team = :id)')
      ->setParameter('id', $parent->getId())
      ->getQuery()
      ->execute();

    $em->remove($repetition);
    $em->flush();

    return true;
  }
}
