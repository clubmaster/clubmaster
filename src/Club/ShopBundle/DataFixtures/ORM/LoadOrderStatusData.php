<?php

namespace Club\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadOrderStatusData implements FixtureInterface
{
  public function load($manager)
  {
    $status = new \Club\ShopBundle\Entity\OrderStatus();
    $status->setStatusName('Pending');
    $status->setIsAccepted(0);
    $status->setIsCancelled(0);
    $status->setPriority(0);
    $manager->persist($status);

    $status = new \Club\ShopBundle\Entity\OrderStatus();
    $status->setStatusName('Processing');
    $status->setIsAccepted(0);
    $status->setIsCancelled(0);
    $status->setPriority(0);
    $manager->persist($status);

    $status = new \Club\ShopBundle\Entity\OrderStatus();
    $status->setStatusName('Preparing');
    $status->setIsAccepted(0);
    $status->setIsCancelled(0);
    $status->setPriority(0);
    $manager->persist($status);

    $status = new \Club\ShopBundle\Entity\OrderStatus();
    $status->setStatusName('Delivered');
    $status->setIsAccepted(1);
    $status->setIsCancelled(0);
    $status->setPriority(0);
    $manager->persist($status);

    $status = new \Club\ShopBundle\Entity\OrderStatus();
    $status->setStatusName('Cancelled');
    $status->setIsAccepted(0);
    $status->setIsCancelled(1);
    $status->setPriority(0);
    $manager->persist($status);

    $manager->flush();
  }
}
