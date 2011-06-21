<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BanController extends Controller
{
  /**
   * @Route("/ban",name="ban")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $bans = $em->getRepository('\Club\UserBundle\Entity\Ban')->findAll();

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
    $ban = $em->find('\Club\UserBundle\Entity\Ban',$id);
    $ban->setExpireDate(new \DateTime(date('Y-m-d',strtotime('+1 month'))));

    $em->persist($ban);
    $em->flush();

    $this->get('session')->setFlash('notice','You ban has been extended');
    return new RedirectResponse($this->generateUrl('ban'));
  }

  /**
   * @Route("/ban/expire/{id}", name="ban_expire")
   */
  public function expireAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $ban = $em->find('\Club\UserBundle\Entity\Ban',$id);

    $em->remove($ban);
    $em->flush();

    $this->get('session')->setFlash('notice','Ban has been expired');
    return new RedirectResponse($this->generateUrl('ban'));
  }
}
