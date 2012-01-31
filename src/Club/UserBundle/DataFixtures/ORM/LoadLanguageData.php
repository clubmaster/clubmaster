<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLanguageData implements FixtureInterface
{
  public function load($manager)
  {
    $language = new \Club\UserBundle\Entity\Language();
    $language->setName('English');
    $language->setCode('en_UK');
    $manager->persist($language);

    $language = new \Club\UserBundle\Entity\Language();
    $language->setName('Danish');
    $language->setCode('da_DK');
    $manager->persist($language);

    $manager->flush();
  }
}
