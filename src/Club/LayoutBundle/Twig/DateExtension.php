<?php

namespace Club\LayoutBundle\Twig;

class DateExtension extends \Twig_Extension
{
  private $container;
  private $em;
  private $security_context;
  private $session;
  private $locale;
  private $timezone;

  public function __construct($container)
  {
    $this->container = $container;
    $this->em = $container->get('doctrine.orm.entity_manager');
    $this->security_context = $container->get('security.context');
    $this->session = $container->get('session');
    $this->locale = $container->get('request')->getLocale();
    $this->timezone = date_default_timezone_get();

    $dateformat = $this->session->get('club_user_dateformat');
    if ($dateformat) $this->locale = $dateformat;

    $timezone = $this->session->get('club_user_timezone');
    if ($timezone) $this->timezone = $timezone;
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
    if (!$this->intlExists())

      return $value->format('Y-m-d');

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
    $fmt = new \IntlDateFormatter($this->locale, $date, \IntlDateFormatter::NONE, $this->timezone);

    return $fmt->format($value);
  }

  public function getDateTime($value, $type='SHORT')
  {
    if (!$this->intlExists())

      return $value->format('Y-m-d H:i');

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
    $fmt = new \IntlDateFormatter($this->locale, $date, $time, $this->timezone);

    return $fmt->format($value);
  }

  public function getTime($value, $type='SHORT')
  {
    if (!$this->intlExists())

      return $value->format('H:i');

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
    $fmt = new \IntlDateFormatter($this->locale, \IntlDateFormatter::NONE, $time, $this->timezone);

    return $fmt->format($value);
  }

  public function getDay($value)
  {
    if (!$value instanceof \DateTime) {
      $date = new \DateTime('next monday');
      $date->add(new \DateInterval('P'.($value-1).'D'));
    } else {
      $date = $value;
    }

    if (!$this->intlExists())

      return strtolower($date->format('l'));

    $fmt = new \IntlDateFormatter($this->locale, \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, $this->timezone);
    $fmt->setPattern('eeee');

    return $fmt->format($date);
  }

  protected function intlExists()
  {
    return (class_exists('IntlDateFormatter')) ? true : false;
  }

  public function getName()
  {
    return 'date';
  }
}
