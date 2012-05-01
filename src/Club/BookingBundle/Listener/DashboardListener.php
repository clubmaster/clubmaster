<?php

namespace Club\BookingBundle\Listener;

class DashboardListener
{
  private $container;
  private $em;
  private $security_context;
  private $templating;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->security_context = $container->get('security.context');
    $this->templating = $container->get('templating');
  }

  public function onMemberView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    if (!$this->security_context->isGranted('IS_AUTHENTICATED_FULLY')) return;
    $s = $this->em->getRepository('ClubUserBundle:UserSetting')->findOneBy(array(
      'user' => $this->security_context->getToken()->getUser()->getId(),
      'attribute' => 'public_booking_activity'
    ));
    if ($s && !$s->getValue()) return;
    if (!$s && !$this->container->getParameter('club_booking.public_user_activity')) return;

    $user = $event->getUser();
    $output = $event->getOutput();

    $bookings = $this->em->getRepository('ClubBookingBundle:Booking')->getLatest($user);
    $output .= $this->templating->render('ClubBookingBundle:Dashboard:member_table.html.twig', array(
      'bookings' => $bookings
    ));

    $event->setOutput($output);
  }

  public function onDashboardView(\Club\UserBundle\Event\FilterOutputEvent $event)
  {
    $output = $event->getOutput();

    $start = new \DateTime();

    $bookings = $this->em->getRepository('ClubBookingBundle:Booking')->getAllFutureBookings($this->security_context->getToken()->getUser(), $start);
    $output .= $this->templating->render('ClubBookingBundle:Dashboard:booking_table.html.twig', array(
      'bookings' => $bookings
    ));

    $event->setOutput($output);
  }
}
