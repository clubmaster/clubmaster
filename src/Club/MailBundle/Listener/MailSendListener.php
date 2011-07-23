<?php

namespace Club\MailBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class MailSendListener
{
  protected $em;
  protected $mailer;
  protected $swiftmailer_transport_real;

  public function __construct($em, $mailer, $swiftmailer_transport_real)
  {
    $this->em = $em;
    $this->mailer = $mailer;
    $this->swiftmailer_transport_real = $swiftmailer_transport_real;
  }

  public function onMailTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $transport  = $this->mailer->getTransport();

    if ($transport instanceof \Swift_Transport_SpoolTransport) {
      $spool = $transport->getSpool();
      $spool->setMessageLimit(10);
      $spool->setTimeLimit(60);
      $sent = $spool->flushQueue($this->swiftmailer_transport_real);
    }
  }
}
