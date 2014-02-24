<?php

namespace Club\WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * @Route("/weather")
 */
class WeatherController extends Controller
{
    /**
     * @Route("")
     * @Template()
     */
    public function indexAction()
    {
        $url = sprintf('http://api.openweathermap.org/data/2.5/weather?APPID=%s&mode=json&units=%s&lang=%s&',
            urlencode($this->container->getParameter('club_weather.appid')),
            urlencode($this->container->getParameter('club_weather.units')),
            urlencode($this->container->getParameter('club_weather.locale'))
        );

        $forecastUrl = sprintf('http://api.openweathermap.org/data/2.5/forecast/daily?APPID=%s&mode=json&units=%s&cnt=10&lang=%s&',
            urlencode($this->container->getParameter('club_weather.appid')),
            urlencode($this->container->getParameter('club_weather.units')),
            urlencode($this->container->getParameter('club_weather.locale'))
        );

        if ($this->container->getParameter('club_weather.location')) {
            $url = sprintf($url.'q=%s',
                urlencode($this->container->getParameter('club_weather.location'))
            );

            $forecastUrl = sprintf($forecastUrl.'q=%s',
                urlencode($this->container->getParameter('club_weather.location'))
            );

        } elseif ($this->container->getParameter('club_weather.lonlat')) {
            $r = preg_split("/,/", $this->container->getParameter('club_weather.lonlat'));

            $url = sprintf($url.'lon=%s&lat=%s',
                urlencode($r[0]),
                urlencode($r[1])
            );

            $forecastUrl = sprintf($forecastUrl.'lat=%s&lon=%s',
                urlencode($r[0]),
                urlencode($r[1])
            );

        } elseif ($this->container->getParameter('club_weather.cityid')) {
            $url = sprintf($url.'id=%s',
                urlencode($this->container->getParameter('club_weather.cityid'))
            );

            $forecastUrl = sprintf($forecastUrl.'id=%s',
                urlencode($this->container->getParameter('club_weather.cityid'))
            );

        }

        $degree = ($this->container->getParameter('club_weather.units') == 'metric')
            ? 'C'
            : 'F';

        $units = ($this->container->getParameter('club_weather.units') == 'metric')
            ? 'm/s'
            : 'ft/s';

        return array(
            'curr' => $url,
            'forecastUrl' => $forecastUrl,
            'degree' => $degree,
            'units' => $units
        );
    }
}
