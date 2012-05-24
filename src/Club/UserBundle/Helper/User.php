<?php

namespace Club\UserBundle\Helper;

class User
{
  protected $container;
  protected $em;
  protected $event_dispatcher;
  protected $user;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->event_dispatcher = $container->get('event_dispatcher');
    $this->buildUser();
  }

  public function buildUser(\Club\UserBundle\Entity\User $user=null)
  {
    if (!$user) {
      $this->user = new \Club\UserBundle\Entity\User();
      $profile = new \Club\UserBundle\Entity\Profile();
      $this->user->setProfile($profile);
      $profile->setUser($this->user);
      $this->user->setMemberNumber($this->em->getRepository('ClubUserBundle:User')->findNextMemberNumber());

    } else {
      $this->user = $user;
      $profile = $user->getProfile();
    }

    if (!$profile->getProfileAddress()) {
      $address = new \Club\UserBundle\Entity\ProfileAddress();
      $address->setCountry($this->container->getParameter('club_user.default_country'));
      $address->setProfile($profile);
      $profile->setProfileAddress($address);
      $profile->addProfileAddresses($address);
    }
    if (!$profile->getProfilePhone()) {
      $phone = new \Club\UserBundle\Entity\ProfilePhone();
      $phone->setProfile($profile);
      $phone->setContactType('mobile');
      $profile->setProfilePhone($phone);
      $profile->addProfilePhones($phone);
    }
    if (!$profile->getProfileEmail()) {
      $email = new \Club\UserBundle\Entity\ProfileEmail();
      $email->setProfile($profile);
      $email->setContactType('home');
      $profile->setProfileEmail($email);
      $profile->addProfileEmails($email);
    }

    return $this;
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

  public function passwordExpire(\Club\UserBundle\Entity\User $user)
  {
    $reset = new \Club\UserBundle\Entity\ResetPassword();
    $reset->setUser($user);

    $this->em->persist($reset);
  }

  public function updateUserSettings()
  {
    $user = $this->container->get('security.context')->getToken()->getUser();
    $session = $this->container->get('session');

    $settings = $this->em->getRepository('ClubUserBundle:UserSetting')->findBy(array(
      'user' => $user->getId()
    ));

    foreach ($settings as $setting) {
      switch ($setting->getAttribute()) {
      case 'language':
        $session->setLocale($setting->getValue());
        break;
      case 'dateformat':
        $session->set('club_user_dateformat', $setting->getValue());
        break;
      case 'timezone':
        $session->set('club_user_timezone', $setting->getValue());
        break;
      }
    }
  }

  public function loginAs(\Club\UserBundle\Entity\User $user)
  {
    $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
      $user,
      null,
      'user'
    );

    $this->container->get('security.context')->setToken($token);
  }
}
