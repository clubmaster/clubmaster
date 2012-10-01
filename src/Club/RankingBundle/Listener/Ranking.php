<?php

namespace Club\RankingBundle\Listener;

class Ranking
{
    private $em;
    private $club_ranking;

    public function __construct($em, $club_ranking)
    {
        $this->em = $em;
        $this->club_ranking = $club_ranking;
    }

    public function onMatchDelete(\Club\MatchBundle\Event\FilterMatchEvent $event)
    {
        $match = $this->em->getRepository('ClubRankingBundle:Match')->findOneBy(array(
            'match' => $event->getMatch()
        ));

        $this->club_ranking->revokePoint($match);
        $this->em->flush();
    }

    public function onMatchNew(\Club\MatchBundle\Event\FilterMatchEvent $event)
    {
        $match = $this->em->getRepository('ClubRankingBundle:Match')->findOneBy(array(
            'match' => $event->getMatch()
        ));

        $this->processMatch($match);
        $this->em->flush();
    }

    public function onMatchTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
    {
        $matches = $this->em->getRepository('ClubRankingBundle:Match')->getUnprocessed();

        foreach ($matches as $match) {
            if (!$match->getProcessed()) {
                $this->processMatch($match->getMatch());
            }
        }

        $this->em->flush();
    }

    private function processMatch(\Club\RankingBundle\Entity\Match $match)
    {
        $this->club_ranking->addPoint($match->getMatch());

        $match->setProcessed(true);
        $this->em->persist($match);
    }
}
