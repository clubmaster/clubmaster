<?php

namespace Club\ShopBundle\Helper;

class Subscription
{
  protected $em;
  protected $session;
  protected $translator;

  public function __construct($em, $session, $translator)
  {
    $this->em = $em;
    $this->session = $session;
    $this->translator = $translator;
  }

  public function pauseSubscription($subscription)
  {
    if ($this->em->getRepository('ClubShopBundle:Subscription')->getAttributeForSubscription($subscription,'Lifetime')) {
      $this->session->setFlash('error',$this->translator->trans('You cannot pause a lifetime membership.'));

      return;
    }

    // validate that the user is allowed to pause
    $allowed = $this->em->getRepository('ClubShopBundle:Subscription')->getAllowedPauses($subscription);
    if (count($subscription->getSubscriptionPauses()) >= $allowed) {
      $this->session->setFlash('error',$this->translator->trans('You cannot have anymore pauses.'));

      return;
    }

    $pause = new \Club\ShopBundle\Entity\SubscriptionPause();
    $pause->setSubscription($subscription);
    $pause->setStartDate(new \DateTime());
    $pause->setOldExpireDate($subscription->getExpireDate());
    $this->em->persist($pause);

    $subscription->setExpireDate(new \DateTime());
    $this->em->persist($subscription);

    $this->em->flush();

    $this->session->setFlash('notice',$this->translator->trans('Your subscription has been paused.'));
  }

  public function resumeSubscription($subscription)
  {
    $pause = $this->em->getRepository('ClubShopBundle:Subscription')->getActivePause($subscription);
    $pause->setExpireDate(new \DateTime());

    $diff = $pause->getStartDate()->diff($pause->getExpireDate());
    $new = new \DateTime($pause->getOldExpireDate()->format('Y-m-d H:i:s'));
    $new->add($diff);
    $subscription->setExpireDate($new);

    $this->em->persist($subscription);
    $this->em->persist($pause);
    $this->em->flush();

    $this->session->setFlash('notice',$this->translator->trans('Your subscription is now resumed.'));
  }

  public function stopSubscription($subscription)
  {
    $attr = $this->em->createQueryBuilder()
      ->select('a')
      ->from('ClubShopBundle:SubscriptionAttribute', 'a')
      ->where('a.subscription = :subscription')
      ->andWhere('a.attribute_name = :attr')
      ->setParameter('subscription', $subscription->getId())
      ->setParameter('attr', 'auto_renewal')
      ->getQuery()
      ->getOneOrNullResult();

    if ($attr) $this->em->remove($attr);
    $this->em->persist($subscription);
    $this->em->flush();
  }

  public function expireAllSubscriptions(\Club\UserBundle\Entity\User $user)
  {
    $subs = $this->em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($user);

    foreach ($subs as $sub) {
      $this->expireSubscription($sub);
    }
  }

  public function expireSubscription($subscription)
  {
    $this->stopSubscription($subscription);
    $subscription->setExpireDate(new \DateTime());

    $this->em->persist($subscription);
    $this->em->flush();
  }

  public function useTicket(\Club\ShopBundle\Entity\Subscription $subscription, $tickets = 1)
  {
    $left = $this->em->getRepository('ClubShopBundle:Subscription')->getTicketsLeft($subscription);

    if (($left-$tickets) < 0) {
      $this->session->setFlash('error',$this->translator->trans('You do not have enough tickets.'));

      return false;

    } elseif (($left-$tickets) == 0) {
      $this->em->persist($subscription);
      $this->em->flush();
    }

    $st = new \Club\ShopBundle\Entity\SubscriptionTicket();
    $st->setSubscription($subscription);
    $st->setTickets($tickets);

    $this->em->persist($st);
    $this->em->flush();

    $this->session->setFlash('notice',$this->translator->trans('The tickets has been removed from your account.'));
  }
}
