<?php

namespace Club\WelcomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WelcomeController extends Controller
{
    /**
     * @Route("/{_locale}/welcome")
     * @Template()
     */
    public function indexAction()
    {
        $this->get('club_user.flash')->addInfo('blah');
        $this->get('club_user.flash')->addWarning('blah');
        $this->get('club_user.flash')->addError('blah');
        $this->get('club_user.flash')->addNotice('blah');

        $em = $this->getDoctrine()->getManager();

        $announcements = $em->getRepository('ClubNewsBundle:Announcement')->getOpen();

        $welcome = $em->getRepository('ClubWelcomeBundle:Welcome')->findOneBy(array(
            'location' => 1
        ));
        $posts = $em->getRepository('ClubWelcomeBundle:Blog')->findBy(array(), array('id' => 'desc'), 3);

        return array(
            'enable_blog' => $this->container->getParameter('club_welcome.enable_blog'),
            'welcome' => $welcome,
            'posts' => $posts,
            'announcements' => $announcements
        );
    }

    public function switchAction(Request $request)
    {
        return $this->redirect($this->generateUrl('localized', array(
            '_locale' => $request->getLocale()
        )));
    }
}
