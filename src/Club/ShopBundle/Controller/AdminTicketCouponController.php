<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminTicketCouponController extends Controller
{
  /**
   * @Route("/shop/ticket/expire/{id}")
   */
  public function expireAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $ticket = $em->find('ClubShopBundle:TicketCoupon',$id);
    $ticket->expire(new \DateTime());

    $em->persist($ticket);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_shop_subscription',array(
      'id' => $ticket->getUser()->getId()
    )));
  }
}
