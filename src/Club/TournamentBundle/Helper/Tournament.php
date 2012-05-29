<?php

namespace Club\TournamentBundle\Helper;

class Tournament
{
  private $em;
  private $translator;
  private $tournament;
  private $user;
  private $attend;

  public function __construct($em, $translator)
  {
    $this->em = $em;
    $this->translator = $translator;
  }

  public function bindUser(\Club\TournamentBundle\Entity\Tournament $tournament, \Club\UserBundle\Entity\User $user)
  {
    $this->tournament = $tournament;
    $this->user = $user;

    $this->attend = new \Club\TournamentBundle\Entity\Attend();
    $this->attend->setUser($user);
    $this->attend->setTournament($tournament);
    $this->attend->setSeed(1000);

    return $this;
  }

  public function setTournament(\Club\TournamentBundle\Entity\Tournament $tournament)
  {
    $this->tournament = $tournament;

    return $this;
  }

  public function getBracket()
  {
    $games = $this->em->createQueryBuilder()
      ->select('tg')
      ->from('ClubTournamentBundle:TournamentGame', 'tg')
      ->where('tg.tournament = :tournament')
      ->setParameter('tournament', $this->tournament->getId())
      ->getQuery()
      ->getResult();

    $bracket = array();
    foreach ($games as $game) {
      if ($game->getTournamentRound()->getRound() == 0 && $game->getTeamOne() == null) {
        $o = array('blank' => true);
      } else {
        $o = array();
        $m = array(
          'seed' => null,
          'result' => $game->getResult(),
          'user' => null
        );
        if ($game->getTeamOne()) $m['user'] = $game->getTeamOne();
        $o[] = $m;

        $m = array(
          'seed' => null,
          'result' => null,
          'user' => null
        );
        if ($game->getTeamTwo()) $m['user'] = $game->getTeamTwo();
        $o[] = $m;
      }

      if (!isset($bracket[$game->getTournamentRound()->getRound()])) {
        $bracket[$game->getTournamentRound()->getRound()] = array(
          'round' => $game->getTournamentRound()->getRound()+1,
          'name' => $game->getTournamentRound()->getRoundName(),
          'matches' => array()
        );
      }
      $bracket[$game->getTournamentRound()->getRound()]['matches'][$game->getGame()] = $o;
    }

    $round = $this->em->getRepository('ClubTournamentBundle:TournamentRound')->findOneBy(array(
      'tournament' => $this->tournament->getId(),
      'round' => $this->tournament->getRounds()-1
    ));
    $bracket[] = array(
      'round' => $round->getRound()+1,
      'name' => $round->getRoundName(),
      'winner' => array('user' => null)
    );

    return $bracket;
  }

  public function removeUser(\Club\TournamentBundle\Entity\Tournament $tournament, \Club\UserBundle\Entity\User $user)
  {
    $attend = $this->em->getRepository('ClubTournamentBundle:Attend')->findOneBy(array(
      'user' => $user->getId(),
      'tournament' => $tournament->getId()
    ));

    $this->em->remove($attend);
    $this->em->flush();

    return $this;
  }

  public function validate()
  {
    $r = $this->em->createQueryBuilder()
      ->select('a')
      ->from('ClubTournamentBundle:Attend', 'a')
      ->where('a.tournament = :tournament')
      ->andWhere('a.user = :user')
      ->setParameter('tournament', $this->tournament->getId())
      ->setParameter('user', $this->user->getId())
      ->getQuery()
      ->getOneOrNullResult();

    if ($r)
      throw new \Exception($this->translator->trans('User is already in the tournament'));

    if ($this->tournament->getMaxAttend() <= count($this->tournament->getAttends()))
      throw new \Exception($this->translator->trans('The max attend level has already been reached'));

    return $this;
  }

  public function save()
  {
    $this->em->persist($this->attend);
    $this->em->flush();
  }
}
