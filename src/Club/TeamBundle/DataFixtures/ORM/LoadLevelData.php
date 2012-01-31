<?php

namespace Club\TeamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLevelData implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $payment = new \Club\TeamBundle\Entity\Level();
    $payment->setLevelName('Easy');
    $manager->persist($payment);

    $payment = new \Club\TeamBundle\Entity\Level();
    $payment->setLevelName('Medium');
    $manager->persist($payment);

    $payment = new \Club\TeamBundle\Entity\Level();
    $payment->setLevelName('Hard');
    $manager->persist($payment);

    $manager->flush();
  }
}
