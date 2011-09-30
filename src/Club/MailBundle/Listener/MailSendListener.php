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
  protected $event_dispatcher;
  protected $logger;

  public function __construct($em, $mailer, $swiftmailer_transport_real, $clubmaster_mailer, $event_dispatcher)
  {
    $this->em = $em;
    $this->mailer = $mailer;
    $this->swiftmailer_transport_real = $swiftmailer_transport_real;
    $this->clubmaster_mailer = $clubmaster_mailer;
    $this->event_dispatcher = $event_dispatcher;

    $this->logger = new \Swift_Plugins_Loggers_ArrayLogger();
    $this->mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($this->logger));
  }

  public function onMailTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $transport  = $this->mailer->getTransport();

    if ($transport instanceof \Swift_Transport_SpoolTransport) {
      try {
        $spool = $transport->getSpool();
        $spool->setMessageLimit(10);
        $spool->setTimeLimit(60);
        $sent = $spool->flushQueue($this->swiftmailer_transport_real);
      } catch (\Exception $e) {
        $event = new \Club\LogBundle\Event\FilterLogEvent($e->getMessage());
        $this->event_dispatcher->dispatch(\Club\MailBundle\Event\Events::onConnectionError, $event);
      }
    }
  }
}
