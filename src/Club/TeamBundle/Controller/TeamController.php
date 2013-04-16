<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class TeamController extends Controller
{
    /**
     * @Route("/team/team")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $schedules = $em->getRepository('ClubTeamBundle:Schedule')->getAllBetween(
            new \DateTime(),
            new \DateTime(date('Y-m-d 23:59:59', strtotime('+7 day')))
        );

        return array(
            'schedules' => $schedules,
            'user' => $this->getUser()
        );
    }

    /**
     * @Route("/team/team/{id}/attend")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function attendAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $schedule = $em->find('ClubTeamBundle:Schedule', $id);

        $this->get('club_team.team')->bindAttend($schedule, $this->getUser());
        if ($this->get('club_team.team')->isValid()) {
            $this->get('club_team.team')->save();

            $event = new \Club\TeamBundle\Event\FilterScheduleEvent($schedule, $this->getUser());
            $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onTeamAttend, $event);
            $this->get('session')->getFlashBag()->add('notice', 'You are now attending the team.');
        } else {
            $this->get('session')->getFlashBag()->add('error', $this->get('club_team.team')->getError());
        }

        return $this->redirect($this->generateUrl('club_team_team_index'));
    }

    /**
     * @Route("/team/team/{id}/unattend")
     * @Template()
     * @Secure(roles="ROLE_USER")
     */
    public function unattendAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $schedule = $em->find('ClubTeamBundle:Schedule', $id);
        $user = $this->getUser();

        $this->get('club_team.team')->bindUnattend($schedule, $user);
        if ($this->get('club_team.team')->isValid()) {
            $this->get('club_team.team')->remove();

            $event = new \Club\TeamBundle\Event\FilterScheduleEvent($schedule, $user);
            $this->get('event_dispatcher')->dispatch(\Club\TeamBundle\Event\Events::onTeamUnattend, $event);
            $this->get('session')->getFlashBag()->add('notice', 'You are no longer on the team.');
        } else {
            $this->get('session')->getFlashBag()->add('error', $this->get('club_team.team')->getError());
        }

        return $this->redirect($this->generateUrl('club_team_team_index'));
    }
}
