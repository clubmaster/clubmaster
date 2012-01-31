<?php

namespace Club\BookingBundle\Helper;

class Interval
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function getTimePeriod(\DateTime $start, \DateTime $end, \DateInterval $interval)
  {
    $res = array();

    $period = new \DatePeriod($start, $interval, $end);

    foreach ($period as $dt) {
      $res[] = $dt;
    }

    return $res;
  }

  public function getVirtualInterval(\Club\BookingBundle\Entity\Interval $interval, $date)
  {
    // FIXME, get all bookings for interval
    //$bookings = $this->em->getRepository('ClubBookingBundle:Booking'->getAllBetween();
    //if ($booking) {
      //$interval->setBooking($booking);
    //}

    $start = new \DateTime($date->format('Y-m-d').' '.$interval->getStartTime()->format('H:i:s'));
    $end = new \DateTime($date->format('Y-m-d').' '.$interval->getStopTime()->format('H:i:s'));

    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getAllBetween($start, $end, null, $interval->getField()->getLocation(), $interval->getField());
    if ($schedules) {
      $interval->setSchedule($schedules[0]);
    }

    return $interval;
  }
}
