<?php

namespace Club\ShopBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * @Assert\Callback(methods={"isValid"})
 */
class Attribute
{
  /**
   * @Club\ShopBundle\Validator\DateTime()
   */
  public $time_interval;

  /**
   * @Assert\Regex(
   *   pattern="/^\d+$/",
   *   match=true,
   *   message="Not a number"
   * )
   */
  public $ticket;

  public $auto_renewal;

  /**
   * @Assert\Regex(
   *   pattern="/^\d+$/",
   *   match=true,
   *   message="Not a number"
   * )
   */
  public $allowed_pauses;

  /**
   * @Assert\Date()
   */
  public $start_date;

  /**
   * @Assert\Date()
   */
  public $expire_date;

  /**
   * @Assert\Date()
   */
  public $start_time;

  /**
   * @Assert\Date()
   */
  public $stop_time;

  public $location;

  public $booking;

  public $team;

  public function getNextDates()
  {
    if ($this->start_date && $this->expire_date && $this->auto_renewal == 'Y') {
      $next_start_date = clone $this->start_date;
      $next_expire_date = clone $this->expire_date;

      $interval = new \DateInterval('P1Y');

      while ($next_expire_date->getTimestamp() < time()) {
        $next_start_date->add($interval);
        $next_expire_date->add($interval);
      }
    } else {
      $next_start_date = $this->start_date;
      $next_expire_date = $this->expire_date;
    }

    return array(
      'next_start_date' => $next_start_date,
      'next_expire_date' => $next_expire_date
    );
  }

  public function getNextStartDate()
  {
    $r = $this->getNextDates();

    return $r['next_start_date'];
  }

  public function getNextExpireDate()
  {
    $r = $this->getNextDates();

    return $r['next_expire_date'];
  }

  public function setStartDate($start_date)
  {
    if ($start_date == '') return;

    if (!($start_date instanceof \DateTime)) {
      $this->start_date = new \DateTime($start_date.' 00:00:00');
    } else {
      $this->start_date = $start_date;
    }
  }

  public function getStartDate()
  {
    return $this->start_date;
  }

  public function setExpireDate($expire_date)
  {
    if ($expire_date == '') return;

    if (!($expire_date instanceof \DateTime)) {
      $this->expire_date = new \DateTime($expire_date.' 23:59:59');
    } else {
      $this->expire_date = $expire_date;
    }
  }

  public function getExpireDate()
  {
    return $this->expire_date;
  }

  public function setStartTime($start_time)
  {
    if ($start_time == '') return;

    if (!($start_time instanceof \DateTime)) {
      $this->start_time = new \DateTime(date('Y-m-d').' '.$start_time);
    } else {
      $this->start_time = $start_time;
    }
  }

  public function getStartTime()
  {
    return $this->start_time;
  }

  public function setStopTime($stop_time)
  {
    if ($stop_time == '') return;

    if (!($stop_time instanceof \DateTime)) {
      $this->stop_time = new \DateTime(date('Y-m-d').' '.$stop_time);
    } else {
      $this->stop_time = $stop_time;
    }
  }

  public function getStopTime()
  {
    return $this->stop_time;
  }

  public function setTicket($ticket)
  {
    $this->ticket = $ticket;
  }

  public function getTicket()
  {
    return $this->ticket;
  }

  public function setTimeInterval($time_interval)
  {
    $this->time_interval = $time_interval;
  }

  public function getTimeInterval()
  {
    return $this->time_interval;
  }

  public function setAutoRenewal($auto_renewal)
  {
    $this->auto_renewal = $auto_renewal;
  }

  public function getAutoRenewal()
  {
    return $this->auto_renewal;
  }

  public function setAllowedPauses($allowed_pauses)
  {
    $this->allowed_pauses = $allowed_pauses;
  }

  public function getAllowedPauses()
  {
    return $this->allowed_pauses;
  }

  public function setLocation($location)
  {
    $this->location = $location;
  }

  public function getLocation()
  {
    return $this->location;
  }

  public function setTeam($team)
  {
    $this->team = $team;
  }

  public function getTeam()
  {
    return $this->team;
  }

  public function setBooking($booking)
  {
    $this->booking = $booking;
  }

  public function getBooking()
  {
    return $this->booking;
  }

  public function isValid(ExecutionContextInterface $context)
  {
    if ($this->start_date == '' && $this->expire_date == '' && $this->time_interval == '')
      $context->addViolation('You has to specify a time for the subscription.', array(), null);

    if ($this->auto_renewal == 'Y' && $this->time_interval != '')
      $context->addViolation('You are not able to make yearly renewal with a time interval, choose a start date instead.', array(), null);

    if ($this->expire_date != '' && $this->start_date == '')
      $context->addViolation('You are not able to have an expire date without a start date.', array(), null);

    if (($this->team || $this->booking) && !count($this->location))
      $context->addViolation('You have to select a location for booking or teams', array(), null);
  }
}
