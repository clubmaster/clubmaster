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
        $config = array();
        foreach ($this->container->parameters as $key => $value) {
            if (preg_match("/^club/", $key)) {
                $config[$key] = $value;
            }
        }

        var_dump($config);die();
    }
}
