<?php

namespace Club\RankingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class GameController extends Controller
{

    public function indexAction($name)
    {
        return $this->render('ClubRankingBundle:Default:index.html.twig', array('name' => $name));
    }
}
