<?php

namespace Club\LogBundle\Listener;

class Booking
{
  protected $em;
  protected $security_context;

  public function __construct($em,$security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function onBookingConfirm(\Club\BookingBundle\Event\FilterBookingEvent $event)
  {
    $booking = $event->getBooking();

    $log = new \Club\LogBundle\Entity\Log();
    $log->setEvent('onBookingConfirm');
    $log->setSeverity('informational');
    $log->setLogType('booking');
    $log->setLog('Created a new booking');

    if ($this->security_context->getToken() && $this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))
      $log->setUser($this->security_context->getToken()->getUser());

    $this->em->persist($log);
    $this->em->flush();
  }

  public function onBookingCancel(\Club\BookingBundle\Event\FilterBookingEvent $event)
  {
    $booking = $event->getBooking();

    $log = new \Club\LogBundle\Entity\Log();
    $log->setEvent('onBookingConfirm');
    $log->setSeverity('informational');
    $log->setLogType('booking');
    $log->setLog('Deleted a booking');

    if ($this->security_context->getToken() && $this->security_context->isGranted('IS_AUTHENTICATED_FULLY'))
      $log->setUser($this->security_context->getToken()->getUser());

    $this->em->persist($log);
    $this->em->flush();
  }
}
