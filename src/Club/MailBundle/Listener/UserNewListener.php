<?php

namespace Club\MailBundle\Listener;

class UserNewListener
{
  protected $container;
  protected $em;
  protected $templating;
  protected $router;
  protected $clubmaster_mailer;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->templating = $container->get('templating');
    $this->router = $container->get('router');
    $this->clubmaster_mailer = $container->get('clubmaster_mailer');
  }

  public function onUserNew(\Club\UserBundle\Event\FilterUserEvent $event)
  {
    if (!$this->container->getParameter('club_mail.mail_on_welcome')) return false;

    $user = $event->getUser();
    $email = $user->getProfile()->getProfileEmail();

    if ($email) {
      $this->clubmaster_mailer
        ->init()
        ->setSubject('Welcome')
        ->setFrom()
        ->setTo($email->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Template:user_new.html.twig',array(
          'user' => $user,
          'url' => $this->router->generate('homepage', array(), 1)
        )))
        ->send();
    }
  }
}
