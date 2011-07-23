<?php

namespace Club\UserBundle\Helper;

class Ban
{
  protected $em;
  protected $security_context;

  public function __construct($em, $security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function banUser(\Club\UserBundle\Entity\User $user)
  {
    $ban = new \Club\UserBundle\Entity\Ban();
    $ban->setUser($this->security_context->getToken()->getUser());
    $ban->setType('user');
    $ban->setValue($user->getId());
    $ban->setExpireDate(new \DateTime(date('Y-m-d H:i:s',strtotime("+1 month"))));

    $user->setLocked(1);

    $this->em->persist($user);
    $this->em->persist($ban);
    $this->em->flush();
  }
}
