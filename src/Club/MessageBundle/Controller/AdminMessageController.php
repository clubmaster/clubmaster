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

    $count = $em->getRepository('ClubMessageBundle:Message')->getCount();
    $paginator = new \Club\UserBundle\Helper\Paginator($count, $this->generateUrl('club_message_adminmessage_index'));

    $messages = $em->getRepository('ClubMessageBundle:Message')->getWithPagination($paginator->getOffset(),$paginator->getLimit());

    return array(
      'messages' => $messages,
      'paginator' => $paginator
    );
  }

  /**
   * @Route("/message/recipient/{id}")
   * @Template()
   */
  public function recipientAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

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
    foreach ($message->getFilters() as $filter) {
      $lines[] = array(
        'type' => 'Filter',
        'message' => $filter->getFilterName(),
        'path' => $this->generateUrl('club_message_adminmessage_recipientfilterdelete', array(
          'message_id' => $message->getId(),
          'id' => $filter->getId()
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
    $message = new \Club\MessageBundle\Entity\Message();
    $form = $this->getForm($message);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();

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
   * @Route("/message/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$id);
    $form = $this->createForm(new \Club\MessageBundle\Form\Message(), $message);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

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
   * @Route("/message/attachment/delete/{id}")
   */
  public function attachmentDeleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
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
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $attachment = new \Club\MessageBundle\Entity\MessageAttachment();
    $attachment->setMessage($message);
    $form = $this->createForm(new \Club\MessageBundle\Form\MessageAttachment(), $attachment);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

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
   * @Route("/message/recipient/filter/{id}")
   * @Template()
   */
  public function recipientFilterAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $form = $this->createFormBuilder($message)
      ->add('filters')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($message);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message was queue for delivery.'));
        return $this->redirect($this->generateUrl('club_message_adminmessage_recipient', array('id' => $message->getId())));
      }
    }
    return array(
      'form' => $form->createView(),
      'message' => $message
    );

  }

  /**
   * @Route("/message/recipient/event/{id}")
   * @Template()
   */
  public function recipientEventAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $form = $this->createFormBuilder($message)
      ->add('events')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($message);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message was queue for delivery.'));
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
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $form = $this->createFormBuilder($message)
      ->add('groups')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($message);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message was queue for delivery.'));
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
    $em = $this->getDoctrine()->getEntityManager();
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
    $em = $this->getDoctrine()->getEntityManager();
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
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$message_id);

    $event = $em->find('ClubEventBundle:Event',$id);
    $message->getEvents()->removeElement($event);

    $em->flush();

    return $this->redirect($this->generateUrl('club_message_adminmessage_recipient',array('id' => $message->getId())));
  }

  /**
   * @Route("/message/recipient/filter/delete/{message_id}/{id}")
   * @Template()
   */
  public function recipientFilterDeleteAction($message_id, $id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$message_id);

    $filter = $em->find('ClubUserBundle:Filter',$id);
    $message->getFilters()->removeElement($filter);

    $em->flush();

    return $this->redirect($this->generateUrl('club_message_adminmessage_recipient',array('id' => $message->getId())));
  }


  /**
   * @Route("/message/recipient/user/{id}")
   * @Template()
   */
  public function recipientUserAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $form = $this->createFormBuilder($message)
      ->add('users')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($message);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message was queue for delivery.'));
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
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    return array(
      'message' => $message
    );
  }

  /**
   * @Route("/message/process/{id}/")
   */
  public function processAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $message = $em->find('ClubMessageBundle:Message',$id);

    $message->setProcessed(1);
    $message->setSentAt(new \DateTime());

    $em->persist($message);

    // just to check if user has received the message once
    $this->recipients = array();

    foreach ($message->getFilters() as $filter) {
      $this->processUsers($message, $em->getRepository('ClubUserBundle:User')->getUsers($filter));
    }

    $this->processUsers($message, $message->getUsers());

    foreach ($message->getGroups() as $group) {
      $this->processUsers($message, $group->getUsers());
    }

    foreach ($message->getEvents() as $event) {
      $this->processAttends($message, $event->getAttends());
    }

    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Recipients added to your recipient queue.'));
    return $this->redirect($this->generateUrl('club_message_adminmessage_index'));
  }

  private function processAttends(\Club\MessageBundle\Entity\Message $message, $attends)
  {
    foreach ($attends as $attend) {
      if ($message->getType() == 'mail') {
        $this->sendMail($message,$attend->getUser());
      }
    }
  }

  private function processUsers(\Club\MessageBundle\Entity\Message $message, $users)
  {
    foreach ($users as $user) {
      if ($message->getType() == 'mail') {
        $this->sendMail($message,$user);
      }
    }
  }

  private function sendMail(\Club\MessageBundle\Entity\Message $message, \Club\UserBundle\Entity\User $user)
  {
    if (isset($this->recipients[$user->getId()])) return;

    $this->recipients[$user->getId()] = 1;

    $queue = new \Club\MessageBundle\Entity\MessageQueue();
    $queue->setUser($user);
    $queue->setMessage($message);
    $queue->setProcessed(0);
    $queue->setRecipient($user->getProfile()->getProfileEmail()->getEmailAddress());

    $em = $this->getDoctrine()->getEntityManager();
    $em->persist($queue);
  }

  private function getForm($message)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $message->setSenderName($em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('email_sender_name'));
    $message->setSenderAddress($em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('email_sender_address'));
    $message->setType('mail');
    $message->setUser($this->get('security.context')->getToken()->getUser());

    $form = $this->createForm(new \Club\MessageBundle\Form\Message(), $message);

    return $form;
  }
}
