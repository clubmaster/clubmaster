<?php

namespace Club\Payment\CashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/payment/cash")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
