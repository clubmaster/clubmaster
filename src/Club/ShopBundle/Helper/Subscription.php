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
    if ($this->em->getRepository('ClubShopBundle:Subscription')->getAttributeForSubscription($subscription,'Lifetime')) {
      $this->session->setFlash('error','You cannot pause a lifetime membership.');
      return;
    }

    // validate that the user is allowed to pause
    $allowed = $this->em->getRepository('ClubShopBundle:Subscription')->getAllowedPauses($subscription);
    if (count($subscription->getSubscriptionPauses()) >= $allowed) {
      $this->session->setFlash('error','You cannot have anymore pauses.');
      return;
    }

    $pause = new \Club\ShopBundle\Entity\SubscriptionPause();
    $pause->setSubscription($subscription);
    $pause->setStartDate(new \DateTime());
    $pause->setOldExpireDate($subscription->getExpireDate());
    $this->em->persist($pause);

    $subscription->setIsActive(0);
    $subscription->setExpireDate(null);
    $this->em->persist($subscription);

    $this->em->flush();

    $this->session->setFlash('notice','Your subscription has been paused.');
  }

  public function resumeSubscription($subscription)
  {
    $subscription->setIsActive(1);

    $pause = $this->em->getRepository('ClubShopBundle:Subscription')->getActivePause($subscription);
    $pause->setExpireDate(new \DateTime());

    $diff = $pause->getStartDate()->diff($pause->getExpireDate());
    $new = new \DateTime($pause->getOldExpireDate()->format('Y-m-d'));
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

  public function useTicket(\Club\ShopBundle\Entity\Subscription $subscription, $tickets = 1)
  {
    $left = $this->em->getRepository('ClubShopBundle:Subscription')->getTicketsLeft($subscription);

    if (($left-$tickets) < 0) {
      $this->session->setFlash('error','You dont have enough tickets.');
      return false;

    } elseif (($left-$tickets) == 0) {
      $subscription->setIsActive(0);
      $this->em->persist($subscription);
      $this->em->flush();
    }

    $st = new \Club\ShopBundle\Entity\SubscriptionTicket();
    $st->setSubscription($subscription);
    $st->setTickets($tickets);

    $this->em->persist($st);
    $this->em->flush();

    $this->session->setFlash('notice',$tickets.' ticket was removed from your account.');
  }
}
