<?php

namespace Club\TeamBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AdminParticipantController extends Controller
{
  /**
   * @Route("/team/participant")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $schedules = $em->getRepository('ClubTeamBundle:Schedule')->getAllBetween(
      new \DateTime(date('Y-m-d 00:00:00')),
      new \DateTime(date('Y-m-d 23:59:59', strtotime('+7 day')))
    );

    return array(
      'schedules' => $schedules,
      'user' => $this->get('security.context')->getToken()->getUser()
    );
  }

  /**
   * @Route("/team/participant/{user_id}")
   * @Template()
   */
  public function participantAction($user_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User', $user_id);

    $participant = new \Club\TeamBundle\Entity\Participant();
    $participant->setUser($user);

    $em->persist($participant);
    $em->flush();

    $this->get('session')->setFlash('notice', 'You are now attending the team.');

    return $this->redirect($this->generateUrl('club_team_adminparticipant_index'));
  }
}
