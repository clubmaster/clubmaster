<?php

namespace Club\MailBundle\Listener;

class PasswordResetListener
{
  protected $em;
  protected $templating;
  protected $router;
  protected $clubmaster_mailer;

  public function __construct($em, $templating, $router, $clubmaster_mailer)
  {
    $this->em = $em;
    $this->templating = $templating;
    $this->router = $router;
    $this->clubmaster_mailer = $clubmaster_mailer;
  }

  public function onPasswordReset(\Club\UserBundle\Event\FilterForgotPasswordEvent $event)
  {
    $user = $event->getForgotPassword()->getUser();
    $email = $user->getProfile()->getProfileEmail();

    if ($email) {
      $this->clubmaster_mailer
        ->setSubject('Reset Password')
        ->setTo($email->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Default:password_reset.html.twig',array(
          'user' => $user,
          'url' => $this->router->generate('auth_reset',array(
            'hash' => $event->getForgotPassword()->getHash()),1)
        )))
        ->send();
    }
  }
}
