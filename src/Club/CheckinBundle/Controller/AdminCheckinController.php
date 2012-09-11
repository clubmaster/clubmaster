<?php

namespace Club\CheckinBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/checkin")
 */
class AdminCheckinController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $checkins = $em->getRepository('ClubCheckinBundle:Checkin')->findBy(
      array(),
      array('id' => 'DESC'),
      50
    );

    return array(
      'checkins' => $checkins
    );
  }

  /**
   * @Route("/checkin/{user_id}")
   * @Template()
   */
  public function checkinAction($user_id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->find('ClubUserBundle:User', $user_id);

    $checkin = new \Club\CheckinBundle\Entity\Checkin();
    $checkin->setUser($user);

    $em->persist($checkin);
    $em->flush();

    $this->get('session')->setFlash('notice', 'User has now checked in.');

    return $this->redirect($this->generateUrl('club_checkin_admincheckin_index'));
  }
}
