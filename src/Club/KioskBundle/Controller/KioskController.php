<?php

namespace Club\KioskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class KioskController extends Controller
{
    /**
     * @Route("/kiosk")
     * @Route("/kiosk/index.html")
     * @Template()
     */
    public function indexAction()
    {
        $defaultLocale = 1;

        return array(
            'defaultLocale' => $defaultLocale
        );
    }
}
