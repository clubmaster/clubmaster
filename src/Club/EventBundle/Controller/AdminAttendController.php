<?php

namespace Club\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminAttendController extends Controller
{
  /**
   * @Route("/event/attend/{id}", name="admin_event_attend")
   * @Template()
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $event = $em->find('\Club\EventBundle\Entity\Event', $id);

    $attends = $em->getRepository('\Club\EventBundle\Entity\Attend')->findBy(array(
      'event' => $event->getId()
    ));

    return array(
      'event' => $event,
      'attends' => $attends
    );
  }

  /**
   * @Route("/event/attend/paid/{id}", name="admin_event_attend_paid")
   */
  public function paidAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $attend = $em->find('ClubEventBundle:Attend',$id);
    $attend->setPaid(1);

    $em->persist($attend);
    $em->flush();

    $this->get('session')->setFlash('notice','You changes has been saved.');

    return $this->redirect($this->generateUrl('admin_event_attend',array('id'=>$attend->getEvent()->getId())));
  }

  /**
   * @Route("/event/attend/unpaid/{id}", name="admin_event_attend_unpaid")
   */
  public function unpaidAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $attend = $em->find('ClubEventBundle:Attend',$id);
    $attend->setPaid(0);

    $em->persist($attend);
    $em->flush();

    $this->get('session')->setFlash('notice','You changes has been saved.');

    return $this->redirect($this->generateUrl('admin_event_attend',array('id'=>$attend->getEvent()->getId())));
  }

  /**
   * @Route("/event/attend/delete/{id}", name="admin_event_attend_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $attend = $em->find('ClubEventBundle:Attend',$id);

    $em->remove($attend);
    $em->flush();

    $this->get('session')->setFlash('notice','You changes has been saved.');

    return $this->redirect($this->generateUrl('admin_event_attend',array('id'=>$attend->getEvent()->getId())));
  }

  protected function process($event)
  {
    $form = $this->get('form.factory')->create(new \Club\EventBundle\Form\Event(), $event);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($event);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return $this->redirect($this->generateUrl('admin_event_event'));
      }
    }

    return $form;
  }
}
