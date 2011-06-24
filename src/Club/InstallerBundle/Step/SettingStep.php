<?php

namespace Club\InstallerBundle\Step;

use Symfony\Component\Validator\Constraints as Assert;

class SettingStep
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

  /**
   * @Assert\NotBlank()
   */
  public $smtp_host;

  /**
   * @Assert\NotBlank()
   */
  public $smtp_port;

  /**
   * @Assert\NotBlank()
   */
  public $smtp_username;

  /**
   * @Assert\NotBlank()
   */
  public $smtp_password;

}
