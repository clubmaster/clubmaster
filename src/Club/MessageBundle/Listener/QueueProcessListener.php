<?php

namespace Club\MessageBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class QueueProcessListener
{
  protected $em;
  protected $clubmaster_mailer;

  public function __construct($em, $clubmaster_mailer)
  {
    $this->em = $em;
    $this->clubmaster_mailer = $clubmaster_mailer;
  }

  public function onMessageTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $messages = $this->em->getRepository('ClubMessageBundle:Message')->getAllReady();

    foreach ($messages as $message) {
      // init message
      $this->clubmaster_mailer
        ->setFrom($message->getSenderAddress(), $message->getSenderName())
        ->setBody($message->getMessage(), 'text/html');

      foreach ($message->getMessageAttachment() as $attachment) {
        $this->clubmaster_mailer->attach($attachment);
      }

      // just to check if user has received the message once
      $this->recipients = array();
      foreach ($message->getFilters() as $filter) {
        $this->processUsers($message, $this->em->getRepository('ClubUserBundle:User')->getUsers($filter));
      }

      $this->processUsers($message, $message->getUsers());

      foreach ($message->getGroups() as $group) {
        $this->processUsers($message, $group->getUsers());
      }

      foreach ($message->getEvents() as $event) {
        $this->processAttends($message, $event->getAttends());
      }

      $message->setProcessed(1);
    }

    $this->em->flush();
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
    if (!$user->getProfile()->getProfileEmail()) return;

    try {
    $this->clubmaster_mailer
      ->setTo($user->getProfile()->getProfileEmail()->getEmailAddress())
      ->send();
    } catch (\Exception $e) {
    }
  }
}
