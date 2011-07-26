<?php

namespace Club\MailBundle\Listener;

class OrderNewListener
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

  public function onShopOrder(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    $order = $event->getOrder();
    $email = $order->getUser()->getProfile()->getProfileEmail();

    if ($email) {
      $this->clubmaster_mailer
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
