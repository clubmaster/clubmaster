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
  public $port = '3306';

  /**
   * @Assert\NotBlank()
   */
  public $dbname;

  /**
   * @Assert\NotBlank()
   */
  public $user;

  public $password;
}
