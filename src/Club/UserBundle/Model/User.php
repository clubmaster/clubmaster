<?php

namespace Club\UserBundle\Model;

class User extends Club\UserBundle\Entity\User implements UserInterface
{
  public function loadUserByUsername($username)
  {
  }
}
