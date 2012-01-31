<?php

namespace Club\LayoutBundle\Twig;

class DateExtension extends \Twig_Extension
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
      'club_date' => new \Twig_Filter_Method($this, 'getDate')
    );
  }

  public function getDate($value, $type='MEDIUM')
  {
    $type = strtoupper($type);
    switch ($type) {
    case 'FULL':
      $date = \IntlDateFormatter::FULL;
      break;
    case 'LONG':
      $date = \IntlDateFormatter::LONG;
      break;
    case 'SHORT':
      $date = \IntlDateFormatter::SHORT;
      break;
    default:
      $date = \IntlDateFormatter::MEDIUM;
      break;
    }
    $fmt = new \IntlDateFormatter($this->session->getLocale(), $date, \IntlDateFormatter::NONE);
    return $fmt->format($value);
  }

  public function getName()
  {
    return 'date';
  }
}
