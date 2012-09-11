<?php

namespace Club\LayoutBundle\Twig;

class CurrencyExtension extends \Twig_Extension
{
  private $container;
  private $em;
  private $security_context;
  private $session;
  private $locale;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->security_context = $container->get('security.context');
    $this->session = $container->get('session');
    $this->locale = $container->get('request')->getLocale();
  }

  public function getFilters()
  {
    return array(
      'club_price' => new \Twig_Filter_Method($this, 'getPrice')
    );
  }

  public function getPrice($value)
  {
    if (!$this->intlExists())

      return $value;

    $currency = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey(
      'default_currency',
      $this->em->find('ClubUserBundle:Location', $this->session->get('location_id'))
    );

    $fmt = new \NumberFormatter($this->locale, \NumberFormatter::CURRENCY);
    return $fmt->formatCurrency($value, $currency->getCode());
  }

  protected function intlExists()
  {
    return (class_exists('NumberFormatter')) ? true : false;
  }

  public function getName()
  {
    return 'currency';
  }
}
