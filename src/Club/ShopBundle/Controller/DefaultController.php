<?php

namespace Club\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ClubShopBundle:Default:index.html.twig');
    }
}
