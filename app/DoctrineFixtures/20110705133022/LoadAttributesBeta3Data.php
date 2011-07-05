<?php

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadAttributesBeta3Data implements FixtureInterface
{
  public function load($manager)
  {
    $attributes = array();
    $attributes[] = 'name';
    $attributes[] = 'member_number';

    foreach ($attributes as $attr) {
      $a = new \Club\UserBundle\Entity\Attribute();
      $a->setAttributeName($attr);

      $manager->persist($a);
    }

    $manager->flush();
  }
}
