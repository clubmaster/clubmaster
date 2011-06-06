<?php

namespace Club\MailBundle\Listener;

class PasswordResetListener
{
  protected $em;
  protected $mailer;
  protected $templating;

  public function __construct($em, $mailer, $templating)
  {
    $this->em = $em;
    $this->mailer = $mailer;
    $this->templating = $templating;
  }

  public function onPasswordReset(\Club\UserBundle\Event\FilterUserEvent $event)
  {
    $user = $event->getUser();
    $email = $this->em->getRepository('\Club\UserBundle\Entity\Profile')->getDefaultEmail($user->getProfile());

    $message = \Swift_Message::newInstance()
      ->setSubject('Reset Password')
      ->setFrom('noreply@clubmaster.dk')
      ->setTo($email->getEmailAddress())
      ->setBody($this->templating->render('ClubMailBundle:Default:password_reset.html.twig'));

    $this->mailer->send($message);
  }
}
