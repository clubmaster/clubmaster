<?php

namespace Club\ShopBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadAttributeData implements FixtureInterface
{
  public function load($manager)
  {
    $attributes = array();
    $attributes[] = 'Month';
    $attributes[] = 'Ticket';
    $attributes[] = 'AutoRenewal';
    $attributes[] = 'Lifetime';
    $attributes[] = 'StartDate';
    $attributes[] = 'ExpireData';
    $attributes[] = 'AllowedPauses';
    $attributes[] = 'Location';

    foreach ($attributes as $attr) {
      $a = new \Club\ShopBundle\Entity\Attribute();
      $a->setAttributeName($attr);

      $manager->persist($a);
    }

    $manager->flush();
  }
}
