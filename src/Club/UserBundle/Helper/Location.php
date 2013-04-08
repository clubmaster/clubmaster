<?php

namespace Club\UserBundle\Helper;

class Location
{
    protected $em;
    protected $session;
    protected $logger;

    public function __construct($em, $session, $logger)
    {
        $this->em = $em;
        $this->session = $session;
        $this->logger = $logger;
    }

    public function getCurrent()
    {
        try {
            $location_id = $this->session->get('location_id');

            if ($location_id) {
                return $this->em->find('ClubUserBundle:Location', $location_id);
            }

            $location = $this->em->getRepository('ClubUserBundle:Location')->getFirstLocation();
            $this->setCurrent($location);

            return $location;

        } catch (\Exception $e) {
            $this->logger->err($e->getMessage());
        }
    }

    public function setCurrent(\Club\UserBundle\Entity\Location $location)
    {
        $this->session->set('location_id', $location->getId());
        $this->session->set('location_name', $location->getLocationName());


        return true;
    }
}
