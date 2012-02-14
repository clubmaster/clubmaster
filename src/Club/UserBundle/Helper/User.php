<?php

namespace Club\UserBundle\Helper;

class User
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function buildUser()
  {
    $user = new \Club\UserBundle\Entity\User();
    $profile = new \Club\UserBundle\Entity\Profile();

    $user->setMemberNumber($this->em->getRepository('ClubUserBundle:User')->findNextMemberNumber());

    $address = new \Club\UserBundle\Entity\ProfileAddress();
    $address->setContactType('home');

    $phone = new \Club\UserBundle\Entity\ProfilePhone();
    $phone->setContactType('home');

    $email = new \Club\UserBundle\Entity\ProfileEmail();
    $email->setContactType('home');

    $user->setProfile($profile);
    $profile->setUser($user);
    $profile->setProfileAddress($address);
    $profile->setProfilePhone($phone);
    $profile->setProfileEmail($email);
    $address->setProfile($profile);
    $phone->setProfile($profile);
    $email->setProfile($profile);

    return $user;
  }
}
