<?php

namespace Club\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class AdminAttendController extends Controller
{
  /**
   * @Route("/event/attend/{id}", name="admin_event_attend")
   * @Template()
   */
  public function indexAction(\Club\EventBundle\Entity\Event $event)
  {
    return array(
      'event' => $event
    );
  }

  /**
   * @Route("/event/attend/delete/{id}", name="admin_event_attend_delete")
   */
  public function deleteAction(\Club\EventBundle\Entity\Attend $attend)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $em->remove($attend);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('admin_event_attend',array('id'=>$attend->getEvent()->getId())));
  }

  protected function process($event)
  {
    $form = $this->createForm(new \Club\EventBundle\Form\Event(), $event);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
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
