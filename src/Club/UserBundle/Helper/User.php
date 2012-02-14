<?php

namespace Club\UserBundle\Helper;

class User
{
  protected $em;
  protected $user;

  public function __construct($em)
  {
    $this->em = $em;
    $this->buildUser();
  }

  public function buildUser()
  {
    $this->user = new \Club\UserBundle\Entity\User();
    $profile = new \Club\UserBundle\Entity\Profile();

    $this->user->setMemberNumber($this->em->getRepository('ClubUserBundle:User')->findNextMemberNumber());

    $address = new \Club\UserBundle\Entity\ProfileAddress();
    $phone = new \Club\UserBundle\Entity\ProfilePhone();
    $email = new \Club\UserBundle\Entity\ProfileEmail();

    $this->user->setProfile($profile);
    $profile->setUser($this->user);
    $profile->setProfileAddress($address);
    $profile->setProfilePhone($phone);
    $profile->setProfileEmail($email);

    $address->setProfile($profile);
    $phone->setProfile($profile);
    $email->setProfile($profile);
  }

  public function get()
  {
    return $this->user;
  }
}
