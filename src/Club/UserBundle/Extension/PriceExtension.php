<?php

namespace Club\UserBundle\Extension;

class PriceExtension extends \Twig_Extension
{
  private $em;
  private $security_context;

  public function __construct($em,$security_context)
  {
    $this->em = $em;
    $this->security_context = $security_context;
  }

  public function getFilters()
  {
    return array(
      'price' => new \Twig_Filter_Method($this, 'price')
    );
  }

  public function price($value)
  {
    $currency = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey(
      'default_currency',
      $this->security_context->getToken()->getUser()->getLocation()
    );

    $str = "%.".$currency->getDecimalPlaces()."f";
    if ($currency->getSymbolLeft()) {
      $str = $currency->getSymbolLeft()." ".$str;
    }

    if ($currency->getSymbolRight()) {
      $str = $str." ".$currency->getSymbolRight();
    }

    return sprintf($str, $value);
  }

  public function getName()
  {
    return 'price';
  }
}
