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
    $message->setUser($this->get('security.context')->getToken()->getUser());

    $qb = $em->createQueryBuilder()
      ->select('f')
      ->from('ClubUserBundle:Filter','f')
      ->where('f.user = :user')
      ->setParameter('user',$this->get('security.context')->getToken()->getUser());

    $form = $this->createFormBuilder($message)
      ->add('sender_name')
      ->add('sender_address')
      ->add('filters','entity',array(
        'class' => 'ClubUserBundle:Filter',
        'multiple' => true,
        'query_builder' => $qb
      ))
      ->add('groups')
      ->add('events')
      ->add('users')
      ->add('subject')
      ->add('message')
      ->getForm();

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

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your message will now be processed from queue.'));
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
}
