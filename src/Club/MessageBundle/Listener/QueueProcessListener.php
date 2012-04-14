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
      foreach ($message->getMessageRecipients() as $recipient) {
        $this->sendMail($recipient);
      }

      $message->setProcessed(1);
    }

    $this->em->flush();
  }

  private function sendMail(\Club\MessageBundle\Entity\MessageRecipient $recipient)
  {
    try {
      $this->clubmaster_mailer
        ->setTo($recipient->getRecipient())
        ->send();
    } catch (\Exception $e) {
    }
  }
}
