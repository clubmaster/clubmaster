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
  public $name;

  /**
   * @Assert\NotBlank()
   */
  public $user;

  /**
   * @Assert\NotBlank()
   */
  public $password;
}
