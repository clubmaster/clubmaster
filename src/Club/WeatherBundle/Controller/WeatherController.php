<?php

namespace Club\WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class WeatherController extends Controller
{
    /**
     * @Route("")
     * @Template()
     * @Cache(smaxage="900")
     */
    public function indexAction()
    {
        $city = $this->container->getParameter('club_weather.city');
        $key = $this->container->getParameter('club_weather.key');
        $days = 5;
        $host = 'http://free.worldweatheronline.com/feed/weather.ashx?q=%s&format=json&num_of_days=%s&key=%s';

        $url = sprintf($host,
            $city,
            $days,
            $key);

        $data = json_decode(file_get_contents($url));

        $weather = $data->data->weather;
        foreach ($weather as $i => $w) {
            $weather[$i]->date = new \DateTime($w->date);
        }

        return array(
            'curr' => $data->data->current_condition[0],
            'request' => $data->data->request[0],
            'weather' => $weather
        );
    }
}
