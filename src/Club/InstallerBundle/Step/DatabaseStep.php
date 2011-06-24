<?php

namespace Club\InstallerBundle\Step;

use Symfony\Component\Validator\Constraints as Assert;

class DatabaseStep
{
  /**
   * @Assert\NotBlank()
   */
  public $host;

  /**
   * @Assert\NotBlank()
   */
  public $port;

  /**
   * @Assert\NotBlank()
   */
  public $name;

  /**
   * @Assert\NotBlank()
   */
  public $user;

  public $password;

  public function __construct()
  {
    $this->port = 3306;
  }
}
