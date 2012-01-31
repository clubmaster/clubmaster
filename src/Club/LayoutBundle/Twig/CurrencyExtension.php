<?php

namespace Club\LayoutBundle\Twig;

class CurrencyExtension extends \Twig_Extension
{
  private $em;
  private $security_context;
  private $session;

  public function __construct($em, $security_context, $session)
  {
    $this->em = $em;
    $this->security_context = $security_context;
    $this->session = $session;
  }

  public function getFilters()
  {
    return array(
      'club_price' => new \Twig_Filter_Method($this, 'getPrice')
    );
  }

  public function getPrice($value)
  {
    $currency = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey(
      'default_currency',
      $this->em->find('ClubUserBundle:Location', $this->session->get('location_id'))
    );

    $fmt = new \NumberFormatter($this->session->getLocale(), \NumberFormatter::CURRENCY);
    return $fmt->formatCurrency($value, $currency->getCode());
  }

  public function getName()
  {
    return 'currency';
  }
}
