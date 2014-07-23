<?php

namespace Club\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Media controller.
 *
 * @Route("/media")
 */
class MediaController extends Controller
{

    /**
     * @Route("", name="media")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ClubMediaBundle:Document')->getAllPublic();

        return array(
            'entities' => $entities,
        );
    }
}
