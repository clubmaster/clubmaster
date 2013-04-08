<?php

namespace Club\MailBundle\Listener;

class Cleanup
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function onTaskCleanup(\Club\TaskBundle\Event\FilterTaskEvent $event)
    {
        $date = new \DateTime();
        $date->modify('-1 month');

        $this->em->createQueryBuilder()
            ->delete('ClubMailBundle:Log', 'l')
            ->where("l.created_at < :date")
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }
}
