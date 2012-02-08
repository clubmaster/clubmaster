<?php

namespace Club\ShopBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

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

  public $location;

  public $booking;

  public $team;

  public function isValid(ExecutionContext $context)
  {
    if ($this->auto_renewal == 'Y' && $this->time_interval != '')
      $context->addViolation('You are not able to make yearly renewal with a time interval, choose a start date instead.', array(), null);

    if ($this->expire_date != '' && $this->start_date == '')
      $context->addViolation('You are not able to have an expire date without a start date.', array(), null);
  }
}
