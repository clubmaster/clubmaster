<?php

namespace Club\MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminMessageController extends Controller
{
  /**
   * @Route("/message")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $messages = $em->getRepository('ClubMessageBundle:Message')->findAll();

    return array(
      'messages' => $messages
    );
  }

  /**
   * @Route("/message/new")
   * @Template()
   */
  public function newAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $message = new \Club\MessageBundle\Entity\Message();
    $message->setSenderName($em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('email_sender_name'));
    $message->setSenderAddress($em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('email_sender_address'));
    $message->setType('mail');

    $form = $this->createForm(new \Club\MessageBundle\Form\Message(), $message);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($message);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message was queue for delivery.'));
        return $this->redirect($this->generateUrl('club_message_adminmessage_index'));
      }
    }
    return array(
      'form' => $form->createView()
    );
  }
}
