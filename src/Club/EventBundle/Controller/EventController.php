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
      'user' => $this->get('security.context')->getToken()->getUser()
    );
  }

  /**
   * @Route("/event/event/show/{id}", name="event_event_show")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $event = $em->find('ClubEventBundle:Event',$id);

    return array(
      'event' => $event,
      'user' => $this->get('security.context')->getToken()->getUser()
    );
  }

  /**
   * @Route("/event/event/attend/{id}", name="event_event_attend")
   */
  public function attendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $event = $em->find('ClubEventBundle:Event',$id);

    $attend = new \Club\EventBundle\Entity\Attend();
    $attend->setUser($this->get('security.context')->getToken()->getUser());
    $attend->setEvent($event);

    if ($event->getPrice() == 0) {
      $attend->setPaid(1);
    } else {
      $attend->setPaid(0);
    }

    $errors = $this->get('validator')->validate($attend);
    if (count($errors) > 0) {
      foreach ($errors as $error) {
        $this->get('session')->setFlash('error',$error->getMessage());
      }
    } else {
      $em->persist($attend);
      $em->flush();

      $this->get('session')->setFlash('notice','You are now signup for this event.');

      $e = new \Club\EventBundle\Event\FilterEventEvent($event);
      $this->get('event_dispatcher')->dispatch(\Club\EventBundle\Event\Events::onEventAttend, $e);
    }

    return $this->redirect($this->generateUrl('event_event'));
  }

  /**
   * @Route("/event/event/unattend/{id}", name="event_event_unattend")
   */
  public function unattendAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $event = $em->find('ClubEventBundle:Event', $id);

    $attend = $em->getRepository('ClubEventBundle:Attend')->findOneBy(array(
      'user' => $this->get('security.context')->getToken()->getUser()->getId(),
      'event' => $event->getId()
    ));

    $em->remove($attend);
    $em->flush();

    $this->get('session')->setFlash('notice','Your signup has been cancelled.');
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
