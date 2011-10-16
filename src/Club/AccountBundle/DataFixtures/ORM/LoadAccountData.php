<?php

namespace Club\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadAccountData implements FixtureInterface
{
  public function load($manager)
  {
    $account = new \Club\AccountBundle\Entity\Account();
    $account->setAccountName('Cash In Bash');
    $account->setAccountNumber('1001');
    $account->setAccountType('asset');
    $manager->persist($account);

    $account = new \Club\AccountBundle\Entity\Account();
    $account->setAccountName('Income');
    $account->setAccountNumber('4001');
    $account->setAccountType('income');
    $manager->persist($account);

    $account = new \Club\AccountBundle\Entity\Account();
    $account->setAccountName('VAT');
    $account->setAccountNumber('4002');
    $account->setAccountType('income');
    $manager->persist($account);

    $account = new \Club\AccountBundle\Entity\Account();
    $account->setAccountName('Discount');
    $account->setAccountNumber('4003');
    $account->setAccountType('income');
    $manager->persist($account);

    $account = new \Club\AccountBundle\Entity\Account();
    $account->setAccountName('Expenses');
    $account->setAccountNumber('5001');
    $account->setAccountType('expense');
    $manager->persist($account);

    $manager->flush();
  }
}
