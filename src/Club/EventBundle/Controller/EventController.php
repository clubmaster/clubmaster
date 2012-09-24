<?php

namespace Club\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
  /**
   * @Route("/event/event", name="event_event")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $events = $em->getRepository('ClubEventBundle:Event')->findAll();

    return array(
      'events' => $events,
      'user' => $this->getUser()
    );
  }

  /**
   * @Route("/event/event/show/{id}", name="event_event_show")
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
   * @Route("/event/event/attend/{id}", name="event_event_attend")
   */
  public function attendAction(\Club\EventBundle\Entity\Event $event)
  {
    $attend = new \Club\EventBundle\Entity\Attend();
    $attend->setUser($this->getUser());
    $attend->setEvent($event);

    $errors = $this->get('validator')->validate($attend);
    if (count($errors) > 0) {
      foreach ($errors as $error) {
        $this->get('session')->setFlash('error',$error->getMessage());
      }
    } else {
      $em = $this->getDoctrine()->getEntityManager();
      $em->persist($attend);
      $em->flush();

      $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

      $e = new \Club\EventBundle\Event\FilterEventEvent($event);
      $this->get('event_dispatcher')->dispatch(\Club\EventBundle\Event\Events::onEventAttend, $e);
    }

    return $this->redirect($this->generateUrl('event_event'));
  }

  /**
   * @Route("/event/event/unattend/{id}", name="event_event_unattend")
   */
  public function unattendAction(\Club\EventBundle\Entity\Event $event)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $attend = $em->getRepository('ClubEventBundle:Attend')->findOneBy(array(
      'user' => $this->getUser()->getId(),
      'event' => $event->getId()
    ));

    $em->remove($attend);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    $e = new \Club\EventBundle\Event\FilterEventEvent($event);
    $this->get('event_dispatcher')->dispatch(\Club\EventBundle\Event\Events::onEventUnattend, $e);

    return $this->redirect($this->generateUrl('event_event'));
  }

  /**
   * @Route("/event/ical")
   */
  public function icalAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $events = $em->getRepository('ClubEventBundle:Event')->findAll();

    $response = $this->render('ClubEventBundle:Event:ical.ics.twig', array(
      'events' => $events
    ));

    $response->headers->set('Content-Type', 'text/calendar');

    return $response;
  }
}
