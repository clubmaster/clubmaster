<?php

namespace Club\InstallerBundle\Step;

use Symfony\Component\Validator\Constraints as Assert;

class LocationStep
{
  /**
   * @Assert\NotBlank()
   */
  public $location;

  /**
   * @Assert\NotBlank()
   */
  public $language;

  /**
   * @Assert\NotBlank()
   */
  public $currency;
}
