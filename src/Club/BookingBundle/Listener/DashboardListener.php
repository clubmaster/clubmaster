<?php

namespace Club\BookingBundle\Listener;

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

    $start = new \DateTime();

    $bookings = $this->em->getRepository('ClubBookingBundle:Booking')->getAllFutureBookings($this->security_context->getToken()->getUser(), $start);
    $output .= $this->templating->render('ClubBookingBundle:Dashboard:booking_table.html.twig', array(
      'bookings' => $bookings
    ));

    $event->setOutput($output);
  }
}
