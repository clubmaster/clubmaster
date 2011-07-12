<?php

namespace Club\MailBundle\Listener;

class OrderAcceptedListener
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

  public function onOrderChange(\Club\ShopBundle\Event\FilterOrderEvent $event)
  {
    $order = $event->getOrder();

    if (!$this->em->getRepository('ClubShopBundle:Order')->isFirstAccepted($order))
      return;

    $email = $this->em->getRepository('ClubUserBundle:Profile')->getDefaultEmail($order->getUser()->getProfile());

    if ($email) {
      $this->clubmaster_mailer
        ->setSubject('Order '.$order->getOrderNumber())
        ->setTo($email->getEmailAddress())
        ->setBody($this->templating->render('ClubMailBundle:Default:order_accepted.html.twig',array(
          'order' => $order
        )))
        ->send();
    }
  }
}
