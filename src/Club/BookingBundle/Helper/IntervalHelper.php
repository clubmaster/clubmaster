<?php

namespace Club\BookingBundle\Helper;

use Club\BookingBundle\Entity\Interval;

class IntervalHelper
{
  protected $em;
  protected $session;

  public function __construct($em, $session)
  {
    $this->em = $em;
    $this->session = $session;
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

  public function getVirtualInterval(Interval $interval, $date)
  {
    $start = new \DateTime($date->format('Y-m-d').' '.$interval->getStartTime()->format('H:i:s'));
    $end = new \DateTime($date->format('Y-m-d').' '.$interval->getStopTime()->format('H:i:s'));
    $i = new \DateInterval('PT1S');
    $start->add($i);

    $bookings = $this->em->getRepository('ClubBookingBundle:Booking')->getAllBetween($start, $end, $interval->getField());
    if ($bookings) {
      $interval->setBooking($bookings[0]);
    }

    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getAllBetween($start, $end, null, $interval->getField()->getLocation(), $interval->getField());
    if ($schedules) {
      $interval->setSchedule($schedules[0]);
    }

    $plans = $this->em->getRepository('ClubBookingBundle:Plan')->getBetweenByField($interval->getField(), $start, $end);
    if ($plans) {
      $interval->setPlan($plans[0]);
    }

    return $interval;
  }

  public function getDays()
  {
    $d = new \DateTime('next monday');
    $i = new \DateInterval('P1D');
    $p = new \DatePeriod($d, $i, 6);

    $days = array();
    foreach ($p as $i=>$dt) {
      $days[($i+1)] = $dt->format('l');
    }

    return $days;
  }
}
