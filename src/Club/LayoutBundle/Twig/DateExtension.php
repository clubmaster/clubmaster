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
        $this->translator = $container->get('translator');
        $this->timezone = date_default_timezone_get();

        $timezone = $this->session->get('club_user_timezone');
        if ($timezone) $this->timezone = $timezone;
    }

    public function getLocale()
    {
        $dateformat = $this->session->get('club_user_dateformat');

        if ($dateformat) {
            return $dateformat;
        }

        return $this->container->get('request')->getLocale();
    }

    public function getFilters()
    {
        return array(
            'club_date' => new \Twig_Filter_Method($this, 'getDate'),
            'club_datetime' => new \Twig_Filter_Method($this, 'getDateTime'),
            'club_time' => new \Twig_Filter_Method($this, 'getTime'),
            'club_day' => new \Twig_Filter_Method($this, 'getDay'),
            'club_ago' => new \Twig_Filter_Method($this, 'getAgo'),
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
        $fmt = new \IntlDateFormatter($this->getLocale(), $date, \IntlDateFormatter::NONE, $this->timezone);

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
        $fmt = new \IntlDateFormatter($this->getLocale(), $date, $time, $this->timezone);

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
        $fmt = new \IntlDateFormatter($this->getLocale(), \IntlDateFormatter::NONE, $time, $this->timezone);

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

        $fmt = new \IntlDateFormatter($this->getLocale(), \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, $this->timezone);
        $fmt->setPattern('eeee');

        return $fmt->format($date);
    }

    public function getAgo($value)
    {
        return $this->time_ago($value);
    }

    protected function intlExists()
    {
        return (class_exists('IntlDateFormatter')) ? true : false;
    }

    private function time_ago(\DateTime $date)
    {
        if(empty($date)) {
            return $this->translator->trans("No date provided");
        }
        $periods = array(
            $this->translator->trans("second"),
            $this->translator->trans("minute"),
            $this->translator->trans("hour"),
            $this->translator->trans("day"),
            $this->translator->trans("week"),
            $this->translator->trans("month"),
            $this->translator->trans("year"),
            $this->translator->trans("decade")
        );
        $lengths = array("60","60","24","7","4.35","12","10");
        $now = time();
        $unix_date = $date->format('U');
        // check validity of date
        if(empty($unix_date)) {
            return $this->translator->trans("Bad date");
        }
        // is it future date or past date
        if($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = $this->translator->trans("ago");
        } else {
            $difference = $unix_date - $now;
            $tense = $this->translator->trans("from now");
        }
        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }

    public function getName()
    {
        return 'date';
    }
}
