<?php

namespace Club\MailBundle\Helper;

class Mailer
{
    protected $em;
    protected $mailer;
    protected $container;
    protected $logger;
    protected $message;
    protected $event_dispatcher;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->mailer = $container->get('mailer');
        $this->logger = $container->get('logger');
        $this->event_dispatcher = $container->get('event_dispatcher');

        $this->init();
    }

    public function init()
    {
        $this->message = \Swift_Message::newInstance();

        return $this;
    }

    public function setDecorator($recipients)
    {
        $replacements = array();
        foreach ($recipients as $user) {
            $replacements[$user->getEmail()] = array(
                '{name}' => $user->getName()
            );
        }

        $decorator = new \Swift_Plugins_DecoratorPlugin($replacements);
        $this->mailer->registerPlugin($decorator);

        return $this;
    }

    public function setFrom($sender_addr = null, $sender_name = null)
    {
        if ($sender_addr == null)
            $sender_addr = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('email_sender_address');

        if ($sender_name == null)
            $sender_name = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey('email_sender_name');

        $sender_addr = ($sender_addr) ? $sender_addr : $this->container->getParameter('club_mail.default_sender_address');
        $sender_name = ($sender_name) ? $sender_name : $this->container->getParameter('club_mail.default_sender_name');

        $this->message->setFrom(array(
            $sender_addr => $sender_name
        ));

        return $this;
    }

    public function setSubject($subject)
    {
        $this->message->setSubject($subject);

        return $this;
    }

    public function setTo($to)
    {
        try {
            $this->message->setTo($to);
        } catch (\Exception $e) {
            $this->logger->err('Error! '.$e->getMessage());
        }

        return $this;
    }

    public function setBody($body, $type=null)
    {
        $this->message->setBody($body, $type);

        return $this;
    }

    public function attach($attachment)
    {
        $this->message->attach(
            \Swift_Attachment::fromPath($attachment->getAbsolutePath())
            ->setFilename($attachment->getFileName())
        );

        return $this;
    }

    public function send()
    {
        try {
            $this->mailer->send($this->message);
        } catch (\Exception $e) {
            $this->logger->err('Error! '.$e->getMessage());
        }
    }

    public function flushQueue()
    {
        $transport  = $this->mailer->getTransport();

        if ($transport instanceof \Swift_Transport_SpoolTransport) {
            try {
                $spool = $transport->getSpool();
                $spool->setMessageLimit(60);
                $spool->setTimeLimit(60);
                $sent = $spool->flushQueue($this->container->get('swiftmailer.transport.real'));

                if ($sent > 0) {
                    $event = new \Club\LogBundle\Event\FilterLogEvent(sprintf('Sent %s emails', $sent), 'onMailTask', 'mail', 'informational');
                    $this->event_dispatcher->dispatch(\Club\MailBundle\Event\Events::onConnectionError, $event);
                }
            } catch (\Exception $e) {
                $event = new \Club\LogBundle\Event\FilterLogEvent($e->getMessage(), 'onConnectionError', 'mail');
                $this->event_dispatcher->dispatch(\Club\MailBundle\Event\Events::onConnectionError, $event);
            }
        }
    }
}
