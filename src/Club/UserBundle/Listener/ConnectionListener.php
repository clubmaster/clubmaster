<?php

namespace Club\UserBundle\Listener;

class ConnectionListener
{
    private $em;
    private $security_context;

    public function __construct($em, $security_context)
    {
        $this->em = $em;
        $this->security_context = $security_context;
    }

    public function onMatchNew(\Club\MatchBundle\Event\FilterMatchEvent $event)
    {
        $match = $event->getMatch();

        foreach ($match->getMatchTeams() as $match_team) {
            foreach ($match_team->getTeam()->getUsers() as $user) {
                if ($user != $match->getUser()) {
                    $c = new \Club\UserBundle\Entity\Connection();
                    $c->setUser($match->getUser());
                    $c->setConnection($user);
                    $c->setType('match');

                    $this->em->persist($c);
                }
            }
        }
    }

    public function onBookingConfirm(\Club\BookingBundle\Event\FilterBookingEvent $event)
    {
        $booking = $event->getBooking();

        foreach ($booking->getUsers() as $user) {
            if ($user != $booking->getUser()) {
                $c = new \Club\UserBundle\Entity\Connection();
                $c->setUser($booking->getUser());
                $c->setConnection($user);
                $c->setType('booking');

                $this->em->persist($c);
            }
        }
    }
}
