<?php

namespace Club\UserBundle\Helper;

class Currency
{
    protected $em;
    protected $session;
    protected $currency;

    public function __construct($em, $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function getCurrency()
    {
        if (!$this->currency) {
            $this->currency = $this->em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey(
                'default_currency',
                $this->em->find('ClubUserBundle:Location', $this->session->get('location_id'))
            );
        }

        return $this->currency;
    }
}
