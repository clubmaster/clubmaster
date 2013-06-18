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
            $q = sprintf('%s,%s',
                round($this->container->getParameter('club_weather.latitude'),2),
                round($this->container->getParameter('club_weather.longtitude'),2));
            $key = $this->container->getParameter('club_weather.key');
            $days = 5;
            $host = 'http://free.worldweatheronline.com/feed/weather.ashx?q=%s&format=json&num_of_days=%s&key=%s';

            $url = sprintf($host,
                $q,
                $days,
                $key);

            $r = file_get_contents($url);
            $data = json_decode($r);

            $sun = date_sun_info(
                time(),
                $this->container->getParameter('club_weather.latitude'),
                $this->container->getParameter('club_weather.longtitude')
            );
            $data->data->current_condition[0]->sunrise = new \DateTime(date('Y-m-d H:i:s', $sun['sunrise']));
            $data->data->current_condition[0]->sunset = new \DateTime(date('Y-m-d H:i:s', $sun['sunset']));
            $data->data->current_condition[0]->observation_time = new \DateTime(date('Y-m-d H:i:s', strtotime($data->data->current_condition[0]->observation_time)));

            foreach ($data->data->weather as $w) {
                $sun = date_sun_info(
                    strtotime($w->date),
                    $this->container->getParameter('club_weather.latitude'),
                    $this->container->getParameter('club_weather.longtitude')
                );

                $w->sunrise = new \DateTime(date('Y-m-d H:i:s', $sun['sunrise']));
                $w->sunset = new \DateTime(date('Y-m-d H:i:s', $sun['sunset']));
            }

            file_put_contents($filename, serialize($data));
        } else {
            $data = unserialize(file_get_contents($filename));
        }

        if (!isset($data->data->weather)) {
            throw new \Exception('Could not get data from weather service');
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
