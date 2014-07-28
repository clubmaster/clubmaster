<?php

namespace Club\EventBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/event/attend")
 */
class AdminAttendController extends Controller
{
  /**
   * @Route("/print/{id}")
   * @Template()
   */
  public function printAction(\Club\EventBundle\Entity\Event $event)
  {
    return array(
      'event' => $event
    );
  }

  /**
   * @Route("/delete/{id}", name="admin_event_attend_delete")
   */
  public function deleteAction(\Club\EventBundle\Entity\Attend $attend)
  {
    $em = $this->getDoctrine()->getManager();
    $em->remove($attend);
    $em->flush();

    $this->get('club_user.flash')->addNotice();

    return $this->redirect($this->generateUrl('admin_event_attend',array('id'=>$attend->getEvent()->getId())));
  }

  /**
   * @Route("/{id}", name="admin_event_attend")
   * @Template()
   */
  public function indexAction(\Club\EventBundle\Entity\Event $event)
  {
    return array(
      'event' => $event
    );
  }

  protected function process($event)
  {
    $form = $this->createForm(new \Club\EventBundle\Form\Event(), $event);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();

        $this->get('club_user.flash')->addNotice();

        return $this->redirect($this->generateUrl('admin_event_event'));
      }
    }

    return $form;
  }
}
