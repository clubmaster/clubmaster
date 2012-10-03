<?php

namespace Club\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class AdminEventController extends Controller
{
  /**
   * @Route("/event/event", name="admin_event_event")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $events = $em->getRepository('ClubEventBundle:Event')->findBy(
        array(),
        array('start_date' => 'DESC')
    );

    return array(
      'events' => $events
    );
  }

  /**
   * @Route("/event/event/new/{year}/{month}", defaults={"year" = null, "month" = null})
   * @Template()
   */
  public function newAction($year, $month)
  {
    $event = new \Club\EventBundle\Entity\Event();

    $res = $this->process($event);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/event/event/edit/{id}", name="admin_event_event_edit")
   * @Template()
   */
  public function editAction(\Club\EventBundle\Entity\Event $event)
  {
    $res = $this->process($event);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'event' => $event,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/event/event/delete/{id}", name="admin_event_event_delete")
   */
  public function deleteAction(\Club\EventBundle\Entity\Event $event)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $em->remove($event);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_event_event'));
  }

  protected function process($event)
  {
    $form = $this->createForm(new \Club\EventBundle\Form\Event(), $event);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        if (!$event->getId()) {
          $e = new \Club\EventBundle\Event\FilterEventEvent($event);
          $this->get('event_dispatcher')->dispatch(\Club\EventBundle\Event\Events::onEventAdd, $e);
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($event);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('admin_event_event'));
      }
    }

    return $form;
  }
}
