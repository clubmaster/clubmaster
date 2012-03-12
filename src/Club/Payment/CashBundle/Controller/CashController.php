<?php

namespace Club\Payment\CashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CashController extends Controller
{
    /**
     * @Route("/payment/cash")
     * @Template()
     */
    public function indexAction()
    {
      die('sucker');
    }
}
