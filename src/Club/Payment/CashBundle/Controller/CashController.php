<?php

namespace Club\Payment\CashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CashController extends Controller
{
    /**
     * @Route("/cash/{order_id}")
     * @Template()
     */
    public function indexAction($order_id)
    {
      $em = $this->getDoctrine()->getEntityManager();
      $order = $em->find('ClubShopBundle:Order', $order_id);

      return array(
        'order' => $order,
      );
    }
}
