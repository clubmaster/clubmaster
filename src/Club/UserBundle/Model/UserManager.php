<?php

namespace Club\UserBundle\Model;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager implements UserProviderInterface
{
  function loadUserByUsername($username)
  {
    return $user;
  }

  function loadUser(UserInterface $user)
  {
    if (!$user instanceof User) {
      throw new UnsupportedUserException('Account is not supported.');
    }

    return $this->loadUserByUsername($user->getUsername());
  }

  function supportsClass($class)
  {
  }
}
