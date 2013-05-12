<?php

namespace Club\RankingBundle\Listener;

class Migrate
{
    private $container;
    private $em;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
    }

    public function onVersionMigrate(\Club\InstallerBundle\Event\FilterVersionEvent $event)
    {
        if ($event->getVersion()->getVersion() != '20121016161300') {
            // fit to this version only
            return;
        }

        $rules = $this->em->getRepository('ClubMatchBundle:Rule')->findAll();
        foreach ($rules as $r) {
            $r2 = new \Club\RankingBundle\Entity\Rule();
            $r2->setName($r->getName());
            $r2->setPointWon($r->getPointWon());
            $r2->setPointLost($r->getPointLost());
            $r2->setSamePlayer($r->getSamePlayer());

            $this->em->persist($r2);
        }

        $this->em->flush();

        $leagues = $this->em->getRepository('ClubMatchBundle:League')->findAll();

        foreach ($leagues as $l) {
            $r = new \Club\RankingBundle\Entity\Ranking();
            $r->setName($l->getName());
            $r->setGendeR($l->getGender());
            $r->setInviteOnly($l->getInviteOnly());
            $r->setGameSet($l->getGameSet());
            $r->setType($l->getType());
            $r->setStartDate($l->getStartDate());
            $r->setEndDate($l->getEndDate());

            $rule = $this->em->getRepository('ClubRankingBundle:Rule')->findOneBy(
                array('name' => $l->getRule()->getName())
            );
            $r->setRule($rule);

            foreach ($r->getUsers() as $u) {
                $r->addUser($u);
            }

            foreach ($l->getMatches() as $m) {
                $match = new \Club\RankingBundle\Entity\Match();
                $match->setMatch($m);
                $match->setRanking($r);
                $match->setProcessed(true);

                $this->em->persist($match);
                $r->addMatch($match);
            }

            $tables = $this->em->getRepository('ClubMatchBundle:LeagueTable')->findBy(
                array('league' => $l->getId())
            );
            foreach ($tables as $t) {
                $e = new \Club\RankingBundle\Entity\RankingEntry();
                $e->setRanking($r);
                $e->setPlayed($t->getPlayed());
                $e->setWon($t->getWon());
                $e->setLost($t->getLost());
                $e->setPoint($t->getPoint());
                $e->setTeam($t->getTeam());

                $this->em->persist($e);
            }

            $this->em->persist($r);
        }
    }
}
