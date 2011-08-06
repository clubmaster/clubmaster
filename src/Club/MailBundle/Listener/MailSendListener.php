<?php

namespace Club\MailBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class MailSendListener
{
  protected $em;
  protected $mailer;
  protected $swiftmailer_transport_real;
  protected $clubmaster_mailer;

  public function __construct($em, $mailer, $swiftmailer_transport_real, $clubmaster_mailer)
  {
    $this->em = $em;
    $this->mailer = $mailer;
    $this->swiftmailer_transport_real = $swiftmailer_transport_real;
    $this->clubmaster_mailer = $clubmaster_mailer;
  }

  public function onMailTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $queue = $this->em->getRepository('ClubMessageBundle:MessageQueue')->getQueued();

    foreach ($queue as $message) {
      try {
        $this->clubmaster_mailer
          ->setSubject($message->getMessage()->getSubject())
          ->setFrom($message->getMessage()->getSenderAddress(),$message->getMessage()->getSenderName())
          ->setTo($message->getRecipient())
          ->setBody($message->getMessage()->getMessage());

        foreach ($message->getMessage()->getMessageAttachment() as $attachment) {
          $this->clubmaster_mailer->attach($attachment->getAbsolutePath());
        }

        $this->clubmaster_mailer->send();
      } catch (\Exception $e) {
        $message->setErrorMessage($e->getMessage());
      }

      $message->setProcessed(1);
      $this->em->persist($message);
    }
    $this->em->flush();

    $transport  = $this->mailer->getTransport();

    if ($transport instanceof \Swift_Transport_SpoolTransport) {
      $spool = $transport->getSpool();
      $spool->setMessageLimit(10);
      $spool->setTimeLimit(60);
      $sent = $spool->flushQueue($this->swiftmailer_transport_real);
    }
  }
}
