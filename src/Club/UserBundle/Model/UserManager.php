<?php

namespace Club\UserBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

abstract class UserManager implements UserInterface
{
  public function getRoles()
  {
  }

  public function getPassword()
  {
  }

  public function getSalt()
  {
  }

  public function getUsername()
  {
  }

  public function eraseCredentials()
  {
  }

  public function equals(UserInterface $user)
  {
  }
}
