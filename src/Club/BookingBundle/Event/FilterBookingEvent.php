<?php

namespace Club\BookingBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterBookingEvent extends Event
{
  protected $booking;

  public function __construct(\Club\BookingBundle\Entity\Booking $booking)
  {
    $this->booking = $booking;
  }

  public function getBooking()
  {
    return $this->booking;
  }
}
