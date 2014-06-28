<?php

namespace Club\KioskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class KioskController extends Controller
{
    /**
     * @Route("/kiosk")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
