<?php

namespace Club\MailBundle\Listener;

class PasswordResetListener
{
  protected $em;
  protected $mailer;
  protected $templating;
  protected $router;

  public function __construct($em, $mailer, $templating, $router)
  {
    $this->em = $em;
    $this->mailer = $mailer;
    $this->templating = $templating;
    $this->router = $router;
  }

  public function onPasswordReset(\Club\UserBundle\Event\FilterForgotPasswordEvent $event)
  {
    $user = $event->getForgotPassword()->getUser();
    $email = $this->em->getRepository('ClubUserBundle:Profile')->getDefaultEmail($user->getProfile());

    if (count($email) > 0) {
      $message = \Swift_Message::newInstance()
        ->setSubject('Reset Password')
        ->setFrom('noreply@clubmaster.dk')
        ->setTo($email->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Default:password_reset.html.twig',array(
          'user' => $user,
          'url' => $this->router->generate('auth_reset',array(
            'hash' => $event->getForgotPassword()->getHash()),1)
        )));

      $this->mailer->send($message);
    }
  }
}
