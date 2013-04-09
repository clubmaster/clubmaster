<?php

namespace Club\MailBundle\Listener;

class OrderNewListener
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

  public function onShopOrder(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    if (!$this->container->getParameter('club_mail.mail_on_order')) return false;

    $order = $event->getOrder();
    $email = $order->getUser()->getProfile()->getProfileEmail();

    if ($email) {
      $this->clubmaster_mailer
        ->init()
        ->setSpool(false)
        ->setSubject('Order '.$order->getOrderNumber())
        ->setFrom()
        ->setTo($email->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Template:order_new.html.twig',array(
          'order' => $order
        )))
        ->send();
    }
  }
}
