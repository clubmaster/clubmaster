<?php

namespace Club\RankingBundle\Helper;

class Ranking
{
    protected $em;
    protected $translator;

    protected $ranking;
    protected $match;

    public function __construct($em, $translator)
    {
        $this->em = $em;
        $this->translator = $translator;
    }

    public function addPoint(\Club\MatchBundle\Entity\Match $match)
    {
        $ranking = $this->em->getRepository('ClubRankingBundle:Ranking')->getByMatch($match);
        if (!$ranking) return;

        foreach ($match->getMatchTeams() as $match_team) {

            $lt = $this->em->getRepository('ClubRankingBundle:RankingEntry')->getTeam($ranking, $match_team->getTeam());

            if ($match_team == $match->getWinner()) {
                $lt->setPlayed($lt->getPlayed()+1);
                $lt->setWon($lt->getWon()+1);
                $lt->setPoint($lt->getPoint()+$ranking->getRule()->getPointWon());

            } else {
                $lt->setPlayed($lt->getPlayed()+1);
                $lt->setLost($lt->getLost()+1);
                $lt->setPoint($lt->getPoint()+$ranking->getRule()->getPointLost());

            }

            $this->em->persist($lt);
        }
    }

    public function revokePoint(\Club\RankingBundle\Entity\Match $match)
    {
        if (!$match->getProcessed()) return;
        $match = $match->getMatch();

        $ranking = $this->em->getRepository('ClubRankingBundle:Ranking')->getByMatch($match);
        if (!$ranking) return;

        foreach ($match->getMatchTeams() as $match_team) {

            $lt = $this->em->getRepository('ClubRankingBundle:RankingEntry')->getTeam($ranking, $match_team->getTeam());

            if ($match_team == $match->getWinner()) {
                $lt->setPlayed($lt->getPlayed()-1);
                $lt->setWon($lt->getWon()-1);
                $lt->setPoint($lt->getPoint()-$ranking->getRule()->getPointWon());

            } else {
                $lt->setPlayed($lt->getPlayed()-1);
                $lt->setLost($lt->getLost()-1);

                if ($lt->getPoint() > 0)
                    $lt->setPoint($lt->getPoint()-$ranking->getRule()->getPointLost());

            }

            $this->em->persist($lt);
        }
    }

    public function validateMatch(\Club\RankingBundle\Entity\Ranking $ranking, $club_match)
    {
        try {
            $this->ranking = $ranking;
            $this->match = $club_match->getMatch();

            $this->validateGender($this->match);
            if ($ranking->getInviteOnly()) {
                if (!$ranking->canPlay($user)) {
                    throw new \Exception($this->translator->trans('%user% is not allowed to play in this league.', array(
                        '%user%' => $user->getName()
                    )));
                }
            }

            $this->validateSets($this->match);
            $this->validateRules($ranking);

        } catch (\Exception $e) {
            $club_match->setError($e->getMessage());
        }
    }

    private function validateSets(\Club\MatchBundle\Entity\Match $match)
    {
        $best_of = $this->ranking->getGameSet();
        $set = count(preg_split("/ /", $match->getDisplayResult()));

        if ($set < $best_of/2)
            throw new \Exception('You have not played enough sets.');
    }

    private function validateGender(\Club\MatchBundle\Entity\Match $match)
    {
        if (!$this->ranking->getGender()) return;

        foreach ($match->getMatchTeams() as $team) {
            foreach ($team->getTeam()->getUsers() as $user) {

                if ($user->getProfile()->getGender() != $this->ranking->getGender()) {
                    throw new \Exception($this->translator->trans('Only %gender% is allowed to play in this league.', array(
                        '%gender%' => $this->ranking->getGender()
                    )));
                }
            }
        }
    }

    private function validateRules(\Club\RankingBundle\Entity\Ranking $ranking)
    {
        $qb = $this->em->createQueryBuilder()
            ->select('count(mt.team)')
            ->from('ClubRankingBundle:Ranking', 'r')
            ->join('r.matches', 'm')
            ->join('m.match', 'm2')
            ->join('m2.match_teams', 'mt')
            ->where('r.id = :ranking')
            ->andWhere('mt.team = ?1 OR mt.team = ?2')
            ->groupBy('mt.match')
            ->having('count(mt.team) = 2')
            ->setParameter('ranking', $ranking->getId());

        $i = 0;
        foreach ($this->match->getMatchTeams() as $match_team) {
            $i++;
            $qb
                ->setParameter($i, $match_team->getTeam()->getId());
        }

        $matches = $qb
            ->getQuery()
            ->getResult();

        $total = $ranking->getRule()->getSamePlayer();

        if (count($matches) >= $total) {
            throw new \Exception($this->translator->trans('Teams has already played %count% matches against each other.', array(
                '%count%' => count($matches)
            )));

            return false;
        }

        return true;
    }
}
