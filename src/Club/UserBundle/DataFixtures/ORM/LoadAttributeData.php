<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadAttributeData implements FixtureInterface
{
  public function load($manager)
  {
    $attributes = array();
    $attributes[] = 'min_age';
    $attributes[] = 'max_age';
    $attributes[] = 'gender';
    $attributes[] = 'postal_code';
    $attributes[] = 'city';
    $attributes[] = 'country';
    $attributes[] = 'is_active';
    $attributes[] = 'has_ticket';
    $attributes[] = 'has_subscription';
    $attributes[] = 'location';

    foreach ($attributes as $attr) {
      $a = new \Club\UserBundle\Entity\Attribute();
      $a->setAttributeName($attr);

      $manager->persist($a);
    }

    $manager->flush();
  }
}
