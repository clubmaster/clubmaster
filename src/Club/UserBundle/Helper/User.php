<?php

namespace Club\UserBundle\Helper;

class User
{
  protected $em;
  protected $event_dispatcher;
  protected $user;

  public function __construct($em, $event_dispatcher)
  {
    $this->em = $em;
    $this->buildUser();
    $this->event_dispatcher = $event_dispatcher;
  }

  public function buildUser()
  {
    $this->user = new \Club\UserBundle\Entity\User();
    $profile = new \Club\UserBundle\Entity\Profile();

    $this->user->setProfile($profile);
    $profile->setUser($this->user);

    $this->user->setMemberNumber($this->em->getRepository('ClubUserBundle:User')->findNextMemberNumber());

    $address = new \Club\UserBundle\Entity\ProfileAddress();
    $phone = new \Club\UserBundle\Entity\ProfilePhone();
    $email = new \Club\UserBundle\Entity\ProfileEmail();

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

  public function save()
  {
    $this->em->persist($this->user);
    $this->em->flush();

    $event = new \Club\UserBundle\Event\FilterUserEvent($this->user);
    $this->event_dispatcher->dispatch(\Club\UserBundle\Event\Events::onUserNew, $event);
  }
}
