<?php

namespace Club\MailBundle\Listener;

class UserNewListener
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

  public function onUserNew(\Club\UserBundle\Event\FilterUserEvent $event)
  {
    $user = $event->getUser();
    $email = $user->getProfile()->getProfileEmail();

    if ($email) {
      $this->clubmaster_mailer
        ->setSubject('Welcome')
        ->setFrom()
        ->setTo($email->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Template:user_new.html.twig',array(
          'user' => $user,
          'url' => $this->router->generate('club_user_auth_activate',array('hash' => $user->getActivationCode()),1)
        )))
        ->send();
    }
  }
}
