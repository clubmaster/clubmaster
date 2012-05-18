<?php

namespace Club\TournamentBundle\Helper;

class Tournament
{
  private $em;
  private $translator;
  private $tournament;
  private $user;

  public function __construct($em, $translator)
  {
    $this->em = $em;
    $this->translator = $translator;
  }

  public function bindUser(\Club\TournamentBundle\Entity\Tournament $tournament, \Club\UserBundle\Entity\User $user)
  {
    $this->tournament = $tournament;
    $this->user = $user;
    $this->tournament->addUser($this->user);

    return $this;
  }

  public function removeUser(\Club\TournamentBundle\Entity\Tournament $tournament, \Club\UserBundle\Entity\User $user)
  {
    $this->tournament = $tournament;
    $this->user = $user;
    $this->tournament->getUsers()->removeElement($this->user);

    return $this;
  }

  public function validate()
  {
    if ($this->tournament->getMaxAttend() < count($this->tournament->getUsers()))
      throw new \Exception($this->translator->trans('The max attend level has already been reached'));

    return $this;
  }

  public function save()
  {
    $this->em->persist($this->tournament);
    $this->em->flush();
  }
}
