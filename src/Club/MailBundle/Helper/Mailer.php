<?php

namespace Club\MailBundle\Helper;

class Mailer
{
  protected $em;
  protected $mailer;
  protected $container;
  protected $message;

  public function __construct($em, $mailer, $container)
  {
    $this->em = $em;
    $this->mailer = $mailer;
    $this->container = $container;

    $this->message = \Swift_Message::newInstance();
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
    $this->message->setTo($to);

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
    $this->mailer->send($this->message);
  }
}
