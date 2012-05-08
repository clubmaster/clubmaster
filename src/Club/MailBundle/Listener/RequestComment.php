<?php

namespace Club\MailBundle\Listener;

class RequestComment
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

  public function onRequestCommentNew(\Club\RequestBundle\Event\FilterRequestCommentEvent $event)
  {
    $comment = $event->getRequestComment();
    $email = $comment->getUser()->getProfile()->getProfileEmail();

    if ($email) {
      $this->clubmaster_mailer
        ->setSubject('Player market comment')
        ->setFrom()
        ->setTo($email->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Template:request_comment.html.twig',array(
          'comment' => $comment
        )))
        ->send();
    }
  }
}
