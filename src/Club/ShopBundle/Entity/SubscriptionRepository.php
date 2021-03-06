<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SubscriptionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SubscriptionRepository extends EntityRepository
{
  public function getActivePause($subscription)
  {
    $pause = $this->_em->createQueryBuilder()
      ->select('sp')
      ->from('ClubShopBundle:SubscriptionPause','sp')
      ->where('sp.subscription = ?1')
      ->andWhere('sp.expire_date IS NULL')
      ->setParameter(1, $subscription->getId())
      ->getQuery()
      ->getSingleResult();

    return $pause;
  }

  public function getActiveSubscriptions(\Club\UserBundle\Entity\User $user=null, $type=null, $attr=null, \DateTime $date=null, \Club\UserBundle\Entity\Location $location=null)
  {
    if (!$date)
      $d = new \DateTime();

    $qb = $this->_em->createQueryBuilder()
      ->select('s')
      ->from('ClubShopBundle:Subscription','s')
      ->where('(s.expire_date > :date OR s.expire_date IS NULL)')
      ->andWhere('s.start_date < :date')
      ->setParameter('date', $d);

    if ($type) {
      $qb
        ->andWhere('s.type = :type')
        ->setParameter('type', $type);
    }
    if ($user) {
      $qb
        ->andWhere('s.user = :user')
        ->setParameter('user', $user->getId());
    }
    if ($attr) {
      $qb->leftJoin('s.subscription_attributes', 'sa')
        ->andWhere('sa.attribute_name = :attr')
        ->setParameter('attr', $attr);
    }

    $subscriptions = $qb
      ->getQuery()
      ->getResult();

    if ($location) {
      $res = array();
      foreach ($subscriptions as $s) {
        foreach ($s->getLocation() as $l) {
          if ($l == $location)
            $res[] = $s;
        }
      }

      $subscriptions = $res;
    }

    return $subscriptions;
  }

  public function getComingSubscriptions(\Club\UserBundle\Entity\User $user=null)
  {
    $d = new \DateTime();

    $qb = $this->_em->createQueryBuilder()
      ->select('s')
      ->from('ClubShopBundle:Subscription','s')
      ->where('s.start_date > :date')
      ->setParameter('date',$d);

    if ($user) {
      $qb
        ->andWhere('s.user = :user')
        ->setParameter('user', $user->getId());
    }

    return $qb
      ->getQuery()
      ->getResult();
  }

  public function getExpiredSubscriptions(\Club\UserBundle\Entity\User $user=null)
  {
    $qb = $this->_em->createQueryBuilder()
      ->select('s')
      ->from('ClubShopBundle:Subscription','s')
      ->where('s.expire_date <= :expire_date')
      ->andWhere('s.expire_date IS NOT NULL')
      ->setParameter('expire_date',date('Y-m-d H:i:s'));

    if ($user) {
      $qb
        ->andWhere('s.user = :user')
        ->setParameter('user', $user->getId());
    }

    return $qb
      ->getQuery()
      ->getResult();
  }

  public function getEmptyTicketAutoRenewalSubscriptions()
  {
    $res = array();
    foreach ($this->getActiveSubscriptions(null, 'ticket') as $subscription) {
      if (!$this->getTicketsLeft($subscription) && $this->isAutoRenewal($subscription))
        $res[] = $subscription;
    }

    return $res;
  }

  public function isAutoRenewal(\Club\ShopBundle\Entity\Subscription $subscription)
  {
    $attr = $this->getAttributeQuery($subscription, 'auto_renewal')
      ->getQuery()
      ->getResult();

    if ($attr)

      return true;

    return false;
  }

  public function getAttributeForSubscription(\Club\ShopBundle\Entity\Subscription $subscription, $attribute_name)
  {
    $res = $this->getAttributeQuery($subscription, $attribute_name)
      ->getQuery()
      ->getResult();

    if (!count($res))

      return false;

    return $res[0];
  }

  public function getAllowedPauses(\Club\ShopBundle\Entity\Subscription $subscription)
  {
    $res = $this->getAttributeQuery($subscription, 'allowed_pauses')
      ->getQuery()
      ->getResult();

    if (!count($res))

      return 0;

    return $res[0]->getValue();
  }

  public function getTicketsLeft(\Club\ShopBundle\Entity\Subscription $subscription)
  {
    $used = $this->getUsedTickets($subscription);

    $res = $this->getAttributeQuery($subscription, 'ticket')
      ->getQuery()
      ->getResult();

    if (!count($res))

      return 0;

    return $res[0]->getValue()-$used;
  }

  private function getUsedTickets(\Club\ShopBundle\Entity\Subscription $subscription)
  {
    $tickets = $this->_em->createQueryBuilder()
      ->select('SUM(st.tickets)')
      ->from('ClubShopBundle:SubscriptionTicket','st')
      ->where('st.subscription = ?1')
      ->setParameter(1, $subscription->getId())
      ->getQuery()
      ->getSingleScalarResult();

    if (!$tickets)

      return 0;

    return $tickets;
  }

  private function getAttributeQuery(\Club\ShopBundle\Entity\Subscription $subscription, $attribute_name)
  {
    return $this->_em->createQueryBuilder()
      ->select('sa')
      ->from('ClubShopBundle:SubscriptionAttribute','sa')
      ->where('sa.subscription = :subscription')
      ->andWhere('sa.attribute_name = :attribute')
      ->setParameter('subscription', $subscription->getId())
      ->setParameter('attribute', $attribute_name);
  }
}
