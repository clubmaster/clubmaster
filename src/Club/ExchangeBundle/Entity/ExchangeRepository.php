<?php

namespace Club\ExchangeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ExchangeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExchangeRepository extends EntityRepository
{
  public function getComing()
  {
    return $this->_em->createQueryBuilder()
      ->select('r')
      ->from('ClubExchangeBundle:Exchange', 'r')
      ->where('r.play_time > :date')
      ->orderBy('r.play_time')
      ->setParameter('date', new \DateTime())
      ->getQuery()
      ->getResult();
  }
}