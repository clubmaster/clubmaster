<?php

namespace Club\MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin")
 */
class AdminMessageController extends Controller
{
  /**
   * @Route("/message/page/{page}", name="club_message_adminmessage_index_page")
   * @Route("/message")
   * @Template()
   */
  public function indexAction($page = null)
  {
    $em = $this->getDoctrine()->getManager();

    $count = $em->getRepository('ClubMessageBundle:Message')->getCount();
    $nav = $this->get('club_paginator.paginator')
        ->init(20, $count, $page, 'club_message_adminmessage_index_page');

    $messages = $em->getRepository('ClubMessageBundle:Message')->getWithPagination($nav->getOffset(),$nav->getLimit());

    return array(
      'messages' => $messages,
      'nav' => $nav
    );
  }

  /**
   * @Route("/message/recipient/{id}")
   * @Template()
   */
  public function recipientAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $message = $em->find('ClubMessageBundle:Message',$id);

    $lines = array();
    foreach ($message->getUsers() as $user) {
      $lines[] = array(
        'type' => 'User',
        'message' => $user->getProfile()->getName(),
        'path' => $this->generateUrl('club_message_adminmessage_recipientuserdelete', array(
          'message_id' => $message->getId(),
          'id' => $user->getId()
        ))
      );
    }
    foreach ($message->getGroups() as $group) {
      $lines[] = array(
        'type' => 'Group',
        'message' => $group->getGroupName(),
        'path' => $this->generateUrl('club_message_adminmessage_recipientgroupdelete', array(
          'message_id' => $message->getId(),
          'id' => $group->getId()
        ))
      );
    }
    foreach ($message->getEvents() as $event) {
      $lines[] = array(
        'type' => 'Event',
        'message' => $event->getEventName(),
        'path' => $this->generateUrl('club_message_adminmessage_recipienteventdelete', array(
          'message_id' => $message->getId(),
          'id' => $event->getId()
        ))
      );
    }

    return array(
      'lines' => $lines,
      'message' => $message
    );
  }

  /**
   * @Route("/message/new")
   * @Template()
   */
  public function newAction()
  {
    $message = $this->get('club_message.message')->compose();
    $form = $this->createForm(new \Club\MessageBundle\Form\Message(), $message);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();

        $em->persist($message);
        $em->flush();

        return $this->redirect($this->generateUrl('club_message_adminmessage_attachment',array('id'=>$message->getId())));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/message/delete/{id}")
   * @Template()
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $em->remove($message);
    $em->flush();
    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_message_adminmessage_index'));
  }

  /**
   * @Route("/message/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$id);
    $form = $this->createForm(new \Club\MessageBundle\Form\Message(), $message);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

      if ($form->isValid()) {

        $em->persist($message);
        $em->flush();

        return $this->redirect($this->generateUrl('club_message_adminmessage_attachment',array('id'=>$message->getId())));
      }
    }

    return array(
      'message' => $message,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/message/show/{id}")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$id);
    $form = $this->createForm(new \Club\MessageBundle\Form\Message(), $message);

    return array(
      'message' => $message,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/message/attachment/delete/{id}")
   */
  public function attachmentDeleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $attachment = $em->find('ClubMessageBundle:MessageAttachment',$id);

    $em->remove($attachment);
    $em->flush();

    return $this->redirect($this->generateUrl('club_message_adminmessage_attachment', array('id' => $attachment->getMessage()->getId())));
  }

  /**
   * @Route("/message/attachment/{id}")
   * @Template()
   */
  public function attachmentAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $attachment = new \Club\MessageBundle\Entity\MessageAttachment();
    $attachment->setMessage($message);
    $form = $this->createForm(new \Club\MessageBundle\Form\MessageAttachment(), $attachment);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

      if ($form->isValid()) {

        $em->persist($attachment);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Attachment was added to the message.'));

        return $this->redirect($this->generateUrl('club_message_adminmessage_attachment',array('id'=>$message->getId())));
      }
    }

    return array(
      'attachments' => $message->getMessageAttachment(),
      'message' => $message,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/message/recipient/event/{id}")
   * @Template()
   */
  public function recipientEventAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $form = $this->createFormBuilder($message)
      ->add('events')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $em->persist($message);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Event has been added as recipient for the mail.'));

        return $this->redirect($this->generateUrl('club_message_adminmessage_recipient', array('id' => $message->getId())));
      }
    }

    return array(
      'form' => $form->createView(),
      'message' => $message
    );

  }

  /**
   * @Route("/message/recipient/group/{id}")
   * @Template()
   */
  public function recipientGroupAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $form = $this->createFormBuilder($message)
      ->add('groups')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $em->persist($message);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Group has been added as recipient for the mail.'));

        return $this->redirect($this->generateUrl('club_message_adminmessage_recipient', array('id' => $message->getId())));
      }
    }

    return array(
      'form' => $form->createView(),
      'message' => $message
    );

  }

  /**
   * @Route("/message/recipient/user/delete/{message_id}/{id}")
   * @Template()
   */
  public function recipientUserDeleteAction($message_id, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$message_id);

    $user = $em->find('ClubUserBundle:User',$id);
    $message->getUsers()->removeElement($user);

    $em->flush();

    return $this->redirect($this->generateUrl('club_message_adminmessage_recipient',array('id' => $message->getId())));
  }

  /**
   * @Route("/message/recipient/group/delete/{message_id}/{id}")
   * @Template()
   */
  public function recipientGroupDeleteAction($message_id, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$message_id);

    $group = $em->find('ClubUserBundle:Group',$id);
    $message->getGroups()->removeElement($group);

    $em->flush();

    return $this->redirect($this->generateUrl('club_message_adminmessage_recipient',array('id' => $message->getId())));
  }

  /**
   * @Route("/message/recipient/event/delete/{message_id}/{id}")
   * @Template()
   */
  public function recipientEventDeleteAction($message_id, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$message_id);

    $event = $em->find('ClubEventBundle:Event',$id);
    $message->getEvents()->removeElement($event);

    $em->flush();

    return $this->redirect($this->generateUrl('club_message_adminmessage_recipient',array('id' => $message->getId())));
  }

  /**
   * @Route("/message/recipient/user/{id}")
   * @Template()
   */
  public function recipientUserAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $form = $this->createFormBuilder($message)
      ->add('users')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $em->persist($message);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('User has been added as recipient for the mail.'));

        return $this->redirect($this->generateUrl('club_message_adminmessage_recipient', array('id' => $message->getId())));
      }
    }

    return array(
      'form' => $form->createView(),
      'message' => $message
    );
  }

  /**
   * @Route("/message/log/{id}")
   * @Template()
   */
  public function logAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    return array(
      'message' => $message
    );
  }

  /**
   * @Route("/message/process/{id}")
   */
  public function processAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    if (!$message->getReady()) {
      $message->setReady(1);
      $message->setSentAt(new \DateTime());

      $this->get('club_message.message')->migrateRecipients($message);
      $message->resetRecipients();

      $em->persist($message);
      $em->flush();

      $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message was queue for delivery.'));
    }

    return $this->redirect($this->generateUrl('club_message_adminmessage_index'));
  }
}
