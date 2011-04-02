<?php

namespace Club\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManager;
use Club\UserBundle\Model\UserManager as BaseUserManager;
use Club\UserBundle\Entity\User;

class UserManager extends BaseUserManager
{
  protected $em;

  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  public function createUser()
  {
    $user = new User();
    $user->setAlgorithm('sha512');
    $user->setSalt(hash('sha256',uniqid()));
    $user->setLocked(false);
    $user->setExpired(false);

    return $user;
  }

  public function updateUser($user)
  {
    $this->em->persist($user);
    $this->em->flush();
  }

  public function loadUser(UserInterface $user)
  {
  }

  public function loadUserByUsername($username)
  {
  }

  public function supportsClass($class)
  {
  }
}
