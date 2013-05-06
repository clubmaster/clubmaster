<?php

namespace Club\LogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin")
 */
class ConfigController extends Controller
{
    /**
     * @Route("/log/config")
     * @Template()
     */
    public function indexAction($page = null)
    {
        print_r($this->container->parameters);die();
    }
}
