<?php

namespace Club\MailBundle\Listener;

class Cleanup
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    protected function onTaskCleanup()
    {
        $this->em->createQueryBuilder()
            ->delete()
            ->from('ClubMailBundle:Log', 'l')
            ->where("l.created_at < DATE_SUB(CURRENT_DATE(), 1, 'MONTH')")
            ->getQuery()
            ->getResult();
    }
}
