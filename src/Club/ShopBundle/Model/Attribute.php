<?php

namespace Club\ShopBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

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

  public $lifetime;

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
}
