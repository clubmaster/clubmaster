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
     * @Cache(smaxage="3600")
     */
    public function indexAction()
    {
        $filename = $this->get('kernel')->getCacheDir().'/weather.json';
        $refresh = true;
        $renew = 3600;

        if (is_file($filename)) {
            $stat = stat($filename);

            if ($stat[9] > time()-$renew) {
                $refresh = false;
            }
        }

        if ($refresh) {
            $city = $this->container->getParameter('club_weather.city');
            $key = $this->container->getParameter('club_weather.key');
            $days = 5;
            $host = 'http://free.worldweatheronline.com/feed/weather.ashx?q=%s&format=json&num_of_days=%s&key=%s';

            $url = sprintf($host,
                $city,
                $days,
                $key);

            $r = file_get_contents($url);
            $data = json_decode($r);

            file_put_contents($filename, $r);
        } else {
            $data = json_decode(file_get_contents($filename));
        }

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
