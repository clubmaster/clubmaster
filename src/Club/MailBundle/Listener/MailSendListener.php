<?php

namespace Club\MailBundle\Listener;

class MailSendListener
{
    protected $em;
    protected $mailer;
    protected $swiftmailer_transport_real;
    protected $clubmaster_mailer;
    protected $event_dispatcher;
    protected $reporter;

    public function __construct($em, $mailer, $swiftmailer_transport_real, $clubmaster_mailer, $event_dispatcher)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->swiftmailer_transport_real = $swiftmailer_transport_real;
        $this->clubmaster_mailer = $clubmaster_mailer;
        $this->event_dispatcher = $event_dispatcher;

        $this->reporter = new \Club\MailBundle\Helper\SwiftReporter($em);
        $this->mailer->registerPlugin(new \Swift_Plugins_ReporterPlugin($this->reporter));
    }

    public function onMailTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
    {
        $this->clubmaster_mailer->flushQueue();
    }
}
