<?php

namespace Club\UserBundle\Fixtures;

class Currency
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onFixturesInit()
  {
    $c = array(
      array(
        'code' => 'USD',
        'name' => 'US Dollar'
      ),
      array(
        'code' => 'EUR',
        'name' => 'Euro'
      ),
      array(
        'code' => 'DKK',
        'name' => 'Danish Krone'
      ),
    );

    foreach ($c as $currency) {
      $r = $this->em->getRepository('ClubUserBundle:Currency')->findOneBy(array(
        'code' => $currency['code']
      ));

      if (!$r) {
        $cur = new \Club\UserBundle\Entity\Currency();
        $cur->setCurrencyName($currency['name']);
        $cur->setCode($currency['code']);
        $this->em->persist($cur);
      }
    }

    $this->em->flush();
  }
}
