<?php

namespace Club\UserBundle\Helper;

class Currency
{
    protected $em;
    protected $session;
    protected $club_user_location;
    protected $currency;

    public function __construct($em, $session, $club_user_location)
    {
        $this->em = $em;
        $this->session = $session;
        $this->club_user_location = $club_user_location;
    }

    public function getCurrency()
    {
        if (!$this->currency) {
            $this->currency = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey(
                'default_currency',
                $this->club_user_location->getCurrent()
            );
        }

        return $this->currency;
    }
}
