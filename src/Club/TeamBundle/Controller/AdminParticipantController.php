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
    $participants = $em->getRepository('ClubTeamBundle:Participant')->findBy(
      array(),
      array('id' => 'DESC'),
      50
    );

    return array(
      'participants' => $participants
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
