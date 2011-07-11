<?php

use Doctrine\Common\DataFixtures\FixtureInterface;

class RenameFieldData implements FixtureInterface
{
  public function load($manager)
  {
    $attr = $manager->getRepository('ClubShopBundle:Attribute')->findOneBy(array(
      'attribute_name' => 'ExpireData'
    ));
    $attr->setAttributeName('ExpireDate');
    $manager->persist($attr);

    $config = $manager->getRepository('ClubUserBundle:LocationConfig')->findOneBy(array(
      'config' => 'account_default_vat',
      'location' => 1
    ));
    $config->setValue(2);
    $manager->persist($config);

    $manager->flush();
  }
}
