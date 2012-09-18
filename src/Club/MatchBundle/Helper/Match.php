<?php

namespace Club\MatchBundle\Helper;

class Match
{
    protected $container;
    protected $em;
    protected $translator;
    protected $form_factory;
    protected $event_dispatcher;
    protected $match;
    protected $error;
    protected $is_valid = true;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->translator = $container->get('translator');
        $this->form_factory = $container->get('form.factory');
        $this->event_dispatcher = $container->get('event_dispatcher');
    }

    public function bindMatch(array $data, \Club\MatchBundle\Entity\League $league=null)
    {
        $teams = 2;

        $this->match = new \Club\MatchBundle\Entity\Match();
        if ($league) $this->match->setLeague($league);

        $display = array();
        for ($i = 0; $i < $teams; $i++) {

            try {
                $user = $data['user'.$i];
                if ($league) $this->validateGender($user);

            } catch (\Exception $e) {
                return;
            }
            if (!$user) {
                $this->setError($this->translator->trans('No such user'));

                return;
            }

            if ($league && $league->getInviteOnly()) {
                if (!$league->canPlay($user)) {
                    $this->setError($this->translator->trans('%user% is not allowed to play in this league.', array(
                        '%user%' => $user->getName()
                    )));

                    return;
                }
            }

            $team = $this->getTeam($user);
            $match_team = $this->addTeam($team);

            if ($league) {
                $sets = $league->getGameSet();
            } else {
                if (strlen($data['user0set4'])) {
                    $sets = 5;
                } elseif (strlen($data['user0set3'])) {
                    $sets = 5;
                } elseif (strlen($data['user0set2'])) {
                    $sets = 3;
                } elseif (strlen($data['user0set1'])) {
                    $sets = 3;
                } elseif (strlen($data['user0set0'])) {
                    $sets = 1;
                } else {
                    $this->setError($this->translator->trans('Need to play at least one set.'));
                    return;
                }
            }

            for ($j = 0; $j < $sets; $j++) {
                $set_str = 'user'.$i.'set'.$j;

                if (strlen($data[$set_str])) {
                    if (!isset($display[$i])) $display[$i] = array();
                    $display[$i][$j] = $data[$set_str];

                    $this->addSet($match_team, $j+1, $data[$set_str]);
                }
            }
        }

        if (!$this->validateSets($display, $sets)) {
            return;
        }

        if ($league && !$this->validateRules()) {
            return;
        }

        $str = $this->buildResultString($display);
        $this->match->setDisplayResult($str);

        $winner = $this->findWinner($display);
        $this->match->setWinner($winner);
    }

    public function save()
    {
        $this->em->persist($this->match);
        $this->em->flush();

        $event = new \Club\MatchBundle\Event\FilterMatchEvent($this->match);
        $this->event_dispatcher->dispatch(\Club\MatchBundle\Event\Events::onMatchNew, $event);
    }

    private function validateGender(\Club\UserBundle\Entity\User $user)
    {
        if ($this->match->getLeague()->getGender()) {

            $match_gender = $this->match->getLeague()->getGender();

            if ($user->getProfile()->getGender() != $match_gender) {
                $this->setError($this->translator->trans('Only %gender% is allowed to play in this league.', array(
                    '%gender%' => $match_gender
                )));

                throw new \Exception();
            }
        }
    }

    private function validateRules()
    {
        $qb = $this->em->createQueryBuilder()
            ->select('count(mt.team)')
            ->from('ClubMatchBundle:MatchTeam', 'mt')
            ->leftJoin('mt.match', 'm')
            ->where('m.league = :league')
            ->andWhere('mt.team = ?1 OR mt.team = ?2')
            ->groupBy('mt.match')
            ->having('count(mt.team) = 2')
            ->setParameter('league', $this->match->getLeague()->getId());

        $i = 0;
        foreach ($this->match->getMatchTeams() as $match_team) {
            $i++;
            $qb
                ->setParameter($i, $match_team->getTeam()->getId());
        }

        $matches = $qb
            ->getQuery()
            ->getResult();

        $total = $this->match->getLeague()->getRule()->getMatchSamePlayer();

        if (count($matches) >= $total) {
            $this->setError($this->translator->trans('Teams has already played %count% matches against each other.', array(
                '%count%' => count($matches)
            )));

            return false;
        }

        return true;
    }

    private function validateSets($display, $sets)
    {
        if (!count($display)) {
            $this->setError($this->translator->trans('You have not played enough set'));

            return;
        }

        if (!isset($display[0])) {
            $this->setError($this->translator->trans('Team one has not played any set.'));

            return;
        }

        if (!isset($display[1])) {
            $this->setError($this->translator->trans('Team two has not played any set.'));

            return;
        }

        if (count($display[0]) != count($display[1])) {
            $this->setError($this->translator->trans('The team has not played equal amount of set.'));

            return;
        }

        foreach ($display as $team) {
            $i = 0;
            foreach ($team as $set => $data) {
                $i++;
                if ($set+1 != $i) {
                    $this->setError($this->translator->trans('You has to enter set in the right order.'));

                    return;
                }
            }
        }

        foreach ($display[0] as $set => $data) {
            $set1 = $display[0][$set];
            $set2 = $display[1][$set];

            if ($set1 < 6 && $set2 < 6) {
                $this->setError($this->translator->trans('The match result is not valid.'));

                return;
            }

        }

        if (count($display[0]) < ($sets/2) || count($display[1]) < ($sets/2)) {
            $this->setError($this->translator->trans('You have not played enough set'));

            return false;
        }

        return true;
    }

    private function findWinner($display)
    {
        $won = array(
            0 => 0,
            1 => 0
        );

        $teams = $this->match->getMatchTeams();

        for ($i = 0; $i < count($display[0]); $i++) {
            if ($display[0][$i] > $display[1][$i]) {
                $teams[0]->setSetWon($teams[0]->getSetWon()+1);
                $won[0]++;
            } else {
                $teams[1]->setSetWon($teams[1]->getSetWon()+1);
                $won[1]++;
            }
        }

        if ($won[0] == $won[1]) {
            return false;
        } elseif ($won[0] > $won[1]) {
            $team = $teams[0];
        } else {
            $team = $teams[1];
        }

        return $team;
    }

    private function buildResultString(array $display)
    {
        $ret = '';

        for ($i = 0; $i < count($display[0]); $i++) {
            $ret .= $display[0][$i].'/'.$display[1][$i].' ';
        }

        return trim($ret);
    }

    private function getTeam(\Club\UserBundle\Entity\User $user)
    {
        return $this->em->getRepository('ClubMatchBundle:Team')->getTeamByUser($user);
    }

    private function addTeam(\Club\MatchBundle\Entity\Team $team)
    {
        $match_team = new \Club\MatchBundle\Entity\MatchTeam();
        $match_team->setMatch($this->match);
        $match_team->setTeam($team);
        $this->match->addMatchTeam($match_team);

        return $match_team;
    }

    private function addSet(\Club\MatchBundle\Entity\MatchTeam $team, $game_set, $value)
    {
        $set = new \Club\MatchBundle\Entity\MatchTeamSet();
        $set->setMatchTeam($team);
        $set->setGameSet($game_set);
        $set->setValue($value);
        $team->addMatchTeamSet($set);

        return $set;
    }

    public function setMatch(\Club\MatchBundle\Entity\Match $match)
    {
        $this->match = $match;
    }

    public function getMatch()
    {
        return $this->match;
    }

    public function setError($error)
    {
        $this->error = $error;
        $this->is_valid = false;
    }

    public function getError()
    {
        return $this->error;
    }

    public function isValid()
    {
        return $this->is_valid;
    }

    public function getMatchForm($res, $set)
    {
        $form = $this->form_factory->createBuilder('form', $res)
            ->add('user0', 'jquery_autocomplete', array(
                'help' => 'Info: Insert name of first user.',
                'label' => 'Player'
            ))
            ->add('user1', 'jquery_autocomplete', array(
                'help' => 'Info: Insert name of second user.',
                'label' => 'Player'
            ));

        for ($i = 0; $set > $i; $i++) {
            $form = $form->add('user0set'.$i,'text', array(
                'label' => 'Result',
                'required' => false
            ));
            $form = $form->add('user1set'.$i,'text', array(
                'label' => 'Result',
                'required' => false
            ));
        }

        return $form->getForm();
    }
}
