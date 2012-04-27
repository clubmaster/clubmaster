<?php

namespace Club\UserBundle\Helper;

class ResetPassword
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function passwordExpire(\Club\UserBundle\Entity\User $user)
  {
    $reset = new \Club\UserBundle\Entity\ResetPassword();
    $reset->setUser($user);

    $this->em->persist($reset);
  }
}
