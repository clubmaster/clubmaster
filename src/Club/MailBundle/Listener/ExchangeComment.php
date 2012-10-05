<?php

namespace Club\MailBundle\Listener;

class ExchangeComment
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

  public function onExchangeCommentNew(\Club\ExchangeBundle\Event\FilterExchangeCommentEvent $event)
  {
    $comment = $event->getExchangeComment();
    $email = $comment->getUser()->getProfile()->getProfileEmail();

    if ($email) {
      $this->clubmaster_mailer
        ->init()
        ->setSubject('Exchange comment')
        ->setFrom()
        ->setTo($email->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Template:exchange_comment.html.twig',array(
          'comment' => $comment
        )))
        ->send();
    }
  }
}
