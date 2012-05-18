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

    return $this;
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
