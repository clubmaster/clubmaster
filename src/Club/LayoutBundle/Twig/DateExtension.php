<?php

namespace Club\LayoutBundle\Twig;

class DateExtension extends \Twig_Extension
{
  private $em;
  private $security_context;
  private $session;
  private $locale;

  public function __construct($em, $security_context, $session)
  {
    $this->em = $em;
    $this->security_context = $security_context;
    $this->session = $session;
    $this->locale = $this->session->getLocale();
  }

  public function getFilters()
  {
    return array(
      'club_date' => new \Twig_Filter_Method($this, 'getDate'),
      'club_datetime' => new \Twig_Filter_Method($this, 'getDateTime'),
      'club_time' => new \Twig_Filter_Method($this, 'getTime'),
      'club_day' => new \Twig_Filter_Method($this, 'getDay'),
    );
  }

  public function getDate($value, $type='SHORT')
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
    $fmt = new \IntlDateFormatter($this->locale, $date, \IntlDateFormatter::NONE);
    return $fmt->format($value);
  }

  public function getDateTime($value, $type='SHORT')
  {
    $type = strtoupper($type);
    switch ($type) {
    case 'FULL':
      $date = \IntlDateFormatter::FULL;
      $time = \IntlDateFormatter::FULL;
      break;
    case 'LONG':
      $date = \IntlDateFormatter::LONG;
      $time = \IntlDateFormatter::LONG;
      break;
    case 'SHORT':
      $date = \IntlDateFormatter::SHORT;
      $time = \IntlDateFormatter::SHORT;
      break;
    default:
      $date = \IntlDateFormatter::MEDIUM;
      $time = \IntlDateFormatter::MEDIUM;
      break;
    }
    $fmt = new \IntlDateFormatter($this->locale, $date, $time);
    return $fmt->format($value);
  }

  public function getTime($value, $type='SHORT')
  {
    $type = strtoupper($type);
    switch ($type) {
    case 'FULL':
      $time = \IntlDateFormatter::FULL;
      break;
    case 'LONG':
      $time = \IntlDateFormatter::LONG;
      break;
    case 'SHORT':
      $time = \IntlDateFormatter::SHORT;
      break;
    default:
      $time = \IntlDateFormatter::MEDIUM;
      break;
    }
    $fmt = new \IntlDateFormatter($this->locale, \IntlDateFormatter::NONE, $time);
    return $fmt->format($value);
  }

  public function getDay($value)
  {
    $date = new \DateTime('next monday');
    $date->add(new \DateInterval('P'.($value-1).'D'));

    $fmt = new \IntlDateFormatter($this->locale, \IntlDateFormatter::NONE, \IntlDateFormatter::NONE);
    $fmt->setPattern('eeee');
    return $fmt->format($date);
  }

  public function getName()
  {
    return 'date';
  }
}
