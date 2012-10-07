<?php

namespace Club\WelcomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller
{
    /**
     * @Route("/{_locale}/welcome")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $welcome = $em->getRepository('ClubWelcomeBundle:Welcome')->findOneBy(array(
            'location' => 1
        ));
        $posts = $em->getRepository('ClubWelcomeBundle:Blog')->findBy(array(), array('id' => 'desc'), 3);

        return array(
            'welcome' => $welcome,
            'posts' => $posts
        );
    }

    public function switchAction()
    {
        return $this->redirect($this->generateUrl('localized', array(
            '_locale' => $this->getRequest()->getLocale()
        )));
    }

}
