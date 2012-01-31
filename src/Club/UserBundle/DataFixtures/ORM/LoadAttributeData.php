<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAttributeData implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $attributes = array();
    $attributes[] = 'name';
    $attributes[] = 'member_number';
    $attributes[] = 'min_age';
    $attributes[] = 'max_age';
    $attributes[] = 'gender';
    $attributes[] = 'postal_code';
    $attributes[] = 'city';
    $attributes[] = 'country';
    $attributes[] = 'active';
    $attributes[] = 'has_ticket';
    $attributes[] = 'has_subscription';
    $attributes[] = 'subscription_start';
    $attributes[] = 'subscription_end';
    $attributes[] = 'location';

    foreach ($attributes as $attr) {
      $a = new \Club\UserBundle\Entity\Attribute();
      $a->setAttributeName($attr);

      $manager->persist($a);
    }

    $manager->flush();
  }
}
