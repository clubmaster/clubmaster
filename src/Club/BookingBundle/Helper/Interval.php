<?php

namespace Club\BookingBundle\Helper;

class Interval
{
  public function getTimePeriod(\DateTime $start, \DateTime $end, \DateInterval $interval)
  {
    $res = array();

    $period = new \DatePeriod($start, $interval, $end);

    foreach ($period as $dt) {
      $res[] = $dt;
    }

    return $res;
  }
}
