<?php

namespace Club\LayoutBundle\Twig\Extension;

class PriceExtension extends \Twig_Extension
{
  private $em;
  private $security_context;
  private $session;

  public function __construct($em,$security_context, $session)
  {
    $this->em = $em;
    $this->security_context = $security_context;
    $this->session = $session;
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
      $this->em->find('ClubUserBundle:Location', $this->session->get('location_id'))
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
