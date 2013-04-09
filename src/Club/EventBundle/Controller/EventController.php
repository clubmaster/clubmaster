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
        try {
            $this->get('club_event.event')->validateAttend($event, $this->getUser());

            if ($event->getPrice() > 0) {
                $prod = new \Club\ShopBundle\Entity\CartProduct();
                $prod->setPrice($event->getPrice());
                $prod->setType('event');
                $prod->setProductName(sprintf("Event: %s, #%d",
                    $event->getEventName(),
                    $event->getId()
                ));

                $this->get('cart')
                    ->getCurrent()
                    ->addToCart($prod);

                return $this->redirect($this->generateUrl('shop_checkout'));
            } else {
                $this->get('club_event.event')->attend($event, $this->getUser());
                $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));
            }
        } catch (\Club\EventBundle\Exception\AttendNotAvailableException $e) {
            $this->get('session')->getFlashBag()->add('error',$e->getMessage());
        } catch (\Club\EventBundle\Exception\EventException $e) {
            $this->get('session')->getFlashBag()->add('error',$e->getMessage());
        } catch (\Doctrine\DBAL\DBALException $e) {
            if (preg_match("/Duplicate entry/", $e->getMessage())) {
                $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('You are already subscribed'));
            } else {
                throw $e;
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
            $this->get('session')->getFlashBag()->add('error',$this->get('translator')->trans('Subscription to event is not open'));
        } else {

            $em = $this->getDoctrine()->getManager();
            $attend = $em->getRepository('ClubEventBundle:Attend')->findOneBy(array(
                'user' => $this->getUser()->getId(),
                'event' => $event->getId()
            ));

            $em->remove($attend);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice',$this->get('translator')->trans('Your changes are saved.'));
            $e = new \Club\EventBundle\Event\FilterAttendEvent($attend);
            $this->get('event_dispatcher')->dispatch(\Club\EventBundle\Event\Events::onEventUnattend, $e);
        }

        return $this->redirect($this->generateUrl('event_event'));
    }

    /**
     * @Route("/signin/{id}", name="event_event_signin")
     * @Template()
     */
    public function signinAction(\Club\EventBundle\Entity\Event $event)
    {
        $this->get('session')->set('_security.user.target_path', $this->generateUrl(
            'event_event_attend',
            array('id' => $event->getId()),
            true
        ));

        return $this->redirect($this->generateUrl('club_user_auth_signin'));
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
