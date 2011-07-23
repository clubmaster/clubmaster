<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadAccountData implements FixtureInterface
{
  public function load($manager)
  {
    $account = new \Club\AccountBundle\Entity\Account();
    $account->setAccountName('Cash In Bash');
    $account->setAccountNumber('1010');
    $account->setAccountType('asset');
    $manager->persist($account);

    $account = new \Club\AccountBundle\Entity\Account();
    $account->setAccountName('VAT');
    $account->setAccountNumber('3001');
    $account->setAccountType('income');
    $manager->persist($account);

    $account = new \Club\AccountBundle\Entity\Account();
    $account->setAccountName('Income');
    $account->setAccountNumber('5001');
    $account->setAccountType('income');
    $manager->persist($account);

    $account = new \Club\AccountBundle\Entity\Account();
    $account->setAccountName('Discount');
    $account->setAccountNumber('5020');
    $account->setAccountType('income');
    $manager->persist($account);

    $manager->flush();
  }
}
