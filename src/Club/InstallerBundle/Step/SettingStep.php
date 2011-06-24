<?php

namespace Club\InstallerBundle\Step;

use Symfony\Component\Validator\Constraints as Assert;

class SettingStep
{
  /**
   * @Assert\NotBlank()
   */
  public $first_name;

  /**
   * @Assert\NotBlank()
   */
  public $last_name;

  /**
   * @Assert\NotBlank()
   */
  public $email_address;

  /**
   * @Assert\NotBlank()
   */
  public $password;
}
