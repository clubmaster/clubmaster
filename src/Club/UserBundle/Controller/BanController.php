<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BanController extends Controller
{
  /**
   * @Route("/ban",name="ban")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $bans = $em->getRepository('ClubUserBundle:Ban')->findAll();

    return array(
      'bans' => $bans
    );
  }

  /**
   * @Route("/ban/extend/{id}",name="ban_extend")
   */
  public function extendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $ban = $em->find('ClubUserBundle:Ban',$id);
    $ban->setExpireDate(new \DateTime(date('Y-m-d',strtotime('+1 month'))));

    $em->persist($ban);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    return $this->redirect($this->generateUrl('ban'));
  }

  /**
   * @Route("/ban/expire/{id}", name="ban_expire")
   */
  public function expireAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $ban = $em->find('ClubUserBundle:Ban',$id);
    $ban->setExpireDate(new \DateTime());

    $em->persist($ban);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    return $this->redirect($this->generateUrl('ban'));
  }
}
