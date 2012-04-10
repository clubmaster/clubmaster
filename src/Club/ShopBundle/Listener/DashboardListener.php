<?php

namespace Club\ShopBundle\Listener;

class DashboardListener
{
  private $em;
  private $security_context;
  private $templating;

  public function __construct($em, $security_context, $templating)
  {
    $this->em = $em;
    $this->security_context = $security_context;
    $this->templating = $templating;
  }

  public function onDashboardView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    $output = $event->getOutput();

    $subs = $this->em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($this->security_context->getToken()->getUser());
    $output .= $this->templating->render('ClubShopBundle:Dashboard:subscription_table.html.twig', array(
      'subscriptions' => $subs
    ));

    $orders = $this->em->getRepository('ClubShopBundle:Order')->getOpenOrders(10,$this->security_context->getToken()->getUser());
    $output .= $this->templating->render('ClubShopBundle:Dashboard:order_table.html.twig', array(
      'orders' => $orders
    ));

    $event->setOutput($output);
  }
}
