<?php

namespace Club\ShopBundle\Helper;

class Subscription
{
  protected $em;
  protected $session;

  public function __construct($em, $session)
  {
    $this->em = $em;
    $this->session = $session;
  }

  public function pauseSubscription($subscription)
  {
    // validate that the user is allowed to pause
    $allowed = $this->em->getRepository('ClubShopBundle:Subscription')->getAllowedPauses($subscription);
    if (count($subscription->getSubscriptionPauses()) >= $allowed) {
      $this->session->setFlash('error','You cannot have anymore pauses.');
      return;
    }

    $subscription->setIsActive(0);

    $pause = new \Club\ShopBundle\Entity\SubscriptionPause();
    $pause->setSubscription($subscription);
    $pause->setStartDate(new \DateTime());

    $this->em->persist($subscription);
    $this->em->persist($pause);
    $this->em->flush();

    $this->session->setFlash('notice','Your subscription has been paused.');
  }

  public function resumeSubscription($subscription)
  {
    $subscription->setIsActive(1);

    $pause = $this->em->getRepository('ClubShopBundle:Subscription')->getActivePause($subscription);
    $pause->setExpireDate(new \DateTime());

    $diff = $pause->getStartDate()->diff($pause->getExpireDate());
    $new = new \DateTime($subscription->getExpireDate()->format('Y-m-d'));
    $new->add($diff);
    $subscription->setExpireDate($new);

    $this->em->persist($subscription);
    $this->em->persist($pause);
    $this->em->flush();

    $this->session->setFlash('notice','Your subscription is now resumed.');
  }

  public function expireSubscription($subscription)
  {
    $subscription->setExpireDate(new \DateTime());

    $this->em->persist($subscription);
    $this->em->flush();
  }
}
