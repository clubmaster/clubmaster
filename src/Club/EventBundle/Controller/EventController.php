<?php

namespace Club\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/event")
 */
class EventController extends Controller
{
    /**
     * @Route("", name="event_event")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $public = ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) ? true : false;
        $events = $em->getRepository('ClubEventBundle:Event')->getComing($public);

        return array(
            'events' => $events
        );
    }

    /**
     * @Route("/show/{id}", name="event_event_show")
     * @Template()
     */
    public function showAction(\Club\EventBundle\Entity\Event $event)
    {
        return array(
            'event' => $event,
            'user' => $this->getUser()
        );
    }

    /**
     * @Route("/attend/{id}", name="event_event_attend")
     */
    public function attendAction(\Club\EventBundle\Entity\Event $event)
    {
        if (!$event->isOpen()) {
            $this->get('session')->setFlash('error',$this->get('translator')->trans('Subscription to event is not open'));
        } else {

            $attend = new \Club\EventBundle\Entity\Attend();
            $attend->setUser($this->getUser());
            $attend->setEvent($event);

            $errors = $this->get('validator')->validate($attend);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->get('session')->setFlash('error',$error->getMessage());
                }
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->persist($attend);

                $errors = $this->get('validator')->validate($attend);
                if (!count($errors)) {
                    $em->flush();
                }

                $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

                $e = new \Club\EventBundle\Event\FilterEventEvent($event);
                $this->get('event_dispatcher')->dispatch(\Club\EventBundle\Event\Events::onEventAttend, $e);
            }
        }

        return $this->redirect($this->generateUrl('event_event'));
    }

    /**
     * @Route("/unattend/{id}", name="event_event_unattend")
     */
    public function unattendAction(\Club\EventBundle\Entity\Event $event)
    {
        if (!$event->isOpen()) {
            $this->get('session')->setFlash('error',$this->get('translator')->trans('Subscription to event is not open'));
        } else {

            $em = $this->getDoctrine()->getManager();
            $attend = $em->getRepository('ClubEventBundle:Attend')->findOneBy(array(
                'user' => $this->getUser()->getId(),
                'event' => $event->getId()
            ));

            $em->remove($attend);
            $em->flush();

            $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
            $e = new \Club\EventBundle\Event\FilterEventEvent($event);
            $this->get('event_dispatcher')->dispatch(\Club\EventBundle\Event\Events::onEventUnattend, $e);
        }

        return $this->redirect($this->generateUrl('event_event'));
    }

    /**
     * @Route("/ical")
     */
    public function icalAction()
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('ClubEventBundle:Event')->findAll();

        $response = $this->render('ClubEventBundle:Event:ical.ics.twig', array(
            'events' => $events
        ));

        $response->headers->set('Content-Type', 'text/calendar');

        return $response;
    }
}
