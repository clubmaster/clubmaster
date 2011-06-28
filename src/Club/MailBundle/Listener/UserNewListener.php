<?php

namespace Club\MailBundle\Listener;

class UserNewListener
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

  public function onUserNew(\Club\UserBundle\Event\FilterUserEvent $event)
  {
    $user = $event->getUser();
    $email = $this->em->getRepository('ClubUserBundle:Profile')->getDefaultEmail($user->getProfile());

    if ($email) {
      $message = \Swift_Message::newInstance()
        ->setSubject('Welcome')
        ->setFrom('noreply@clubmaster.dk')
        ->setTo($email->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Default:user_new.html.twig',array(
          'user' => $user,
          'url' => $this->router->generate('club_user_auth_activate',array('hash' => $user->getActivationCode()),1)
        )));

      $this->mailer->send($message);
    }
  }
}
