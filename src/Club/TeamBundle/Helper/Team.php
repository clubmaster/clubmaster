<?php

namespace Club\TeamBundle\Helper;

use Doctrine\ORM\EntityManager;

class Team
{
  protected $em;
  protected $container;
  protected $security_context;
  protected $validator;
  protected $error;
  protected $is_valid = true;
  protected $user;
  protected $team;
  protected $team_user;

  public function __construct(EntityManager $em, $container, $security_context, $validator)
  {
    $this->em = $em;
    $this->container = $container;
    $this->security_context = $security_context;
    $this->validator = $validator;
  }

  public function bindUnattend(\Club\TeamBundle\Entity\Team $team, \Club\UserBundle\Entity\User $user)
  {
    $this->team = $team;
    $this->user = $user;

    if ($this->security_context->isGranted('ROLE_TEAM_ADMIN'))
      return;

    if ($this->security_context->getToken()->getUser() != $user) {
      $this->setError('You do not have permissions to unattend this team');
      return;
    }

    $book_time = clone $this->team->getFirstDate();

    $now = new \DateTime();
    if ($book_time < $now) {
      $this->setError('You cannot unattend teams in the past');
      return;
    }

    $attend = $this->em->getRepository('ClubTeamBundle:TeamUser')->findOneBy(array(
      'user' => $this->user->getId(),
      'team' => $this->team->getId()
    ));

    $diff = ($now->getTimestamp()-$attend->getCreatedAt()->getTimestamp());
    if ($diff < $this->container->getParameter('club_team.cancel_minute_created')*60)
      return;

    $delete_within = clone $book_time;
    $delete_within->sub(new \DateInterval('PT'.$this->container->getParameter('club_team.cancel_minute_before').'M'));
    if ($delete_within < new \DateTime())
      $this->setError('Cannot unattend team because time range is too small');
  }

  public function bindAttend(\Club\TeamBundle\Entity\Team $team, \Club\UserBundle\Entity\User $user)
  {
    $this->team = $team;
    $this->user = $user;

    $this->validate();

    if (!$this->isValid())
      return;
  }

  public function getError()
  {
    return $this->error;
  }

  public function isValid()
  {
    return $this->is_valid;
  }

  protected function prepare()
  {
    $this->team_user = new \Club\TeamBundle\Entity\TeamUser();
    $this->team_user->setUser($this->user);
    $this->team_user->setTeam($this->team);

    $errors = $this->validator->validate($this->team_user, array('attend'));
    foreach ($errors as $error) {
      $this->setError($error->getMessage());
      return;
    }
  }

  public function save()
  {
    $this->em->persist($this->team_user);
    $this->em->flush();

    return $this->team_user;
  }

  public function remove()
  {
    $res = $this->em->getRepository('ClubTeamBundle:TeamUser')->findOneBy(array(
      'user' => $this->user->getId(),
      'team' => $this->team->getId()
    ));

    $this->em->remove($res);
    $this->em->flush();
  }

  protected function setError($error)
  {
    $this->error = $error;
    $this->is_valid = false;
  }

  protected function validate()
  {
    $c = clone $this->team->getFirstDate();

    if ($c < new \DateTime())
      $this->setError('You cannot attend in the past');

    $r = $this->em->createQueryBuilder()
      ->select('su')
      ->from('ClubTeamBundle:TeamUser','su')
      ->where('su.team = :team')
      ->andWhere('su.user = :user')
      ->setParameter('team', $this->team->getId())
      ->setParameter('user', $this->user->getId())
      ->getQuery()
      ->getOneOrNullResult();

    if (count($r))
      $this->setError('You are already on this team');

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(su)')
      ->from('ClubTeamBundle:TeamUser', 'su')
      ->leftJoin('su.team', 's')
      ->where('s.first_date > :first')
      ->andWhere('s.first_date < :end')
      ->andWhere('su.user = :user')
      ->setParameter('user', $this->user->getId())
      ->setParameter('first', $this->team->getFirstDate()->format('Y-m-d').' 00:00:00')
      ->setParameter('end', $this->team->getFirstDate()->format('Y-m-d').' 23:59:59')
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_team.num_team_day'))
      $this->setError('You cannot attend more teams this day');

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(su)')
      ->from('ClubTeamBundle:TeamUser', 'su')
      ->leftJoin('su.team', 's')
      ->where('s.first_date >= CURRENT_DATE()')
      ->andWhere('su.user = :user')
      ->setParameter('user', $this->user->getId())
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_team.num_team_future')) {
      $this->setError('You cannot attend more teams');
      return;
    }

    if (!$this->hasSubscription($this->user)) {
      $this->setError('You do not have permission to use teams.');
      return;
    }

    $this->prepare();
  }

  private function hasSubscription(\Club\UserBundle\Entity\User $user)
  {
    foreach ($user->getSubscriptions() as $subscription) {
      if ($subscription->hasAttribute('team')) {
        foreach ($subscription->getLocation() as $location) {

          if ($location == $this->team->getLocation()) {
            $this->users[] = $user;
            return true;
          }

          foreach ($subscription->getLocation() as $child) {
            if ($child == $this->team->getLocation()) {
              $this->users[] = $user;
              return true;
            }

            foreach ($child->getChilds() as $child2) {
              if ($child2 == $this->team->getLocation()) {
                $this->users[] = $user;
                return true;
              }
            }

            foreach ($child2->getChilds() as $child3) {
              if ($child3 == $this->team->getLocation()) {
                $this->users[] = $user;
                return true;
              }

              foreach ($child3->getChilds() as $child4) {
                if ($child4 == $this->team->getLocation()) {
                  $this->users[] = $user;
                  return true;
                }
              }
            }
          }
        }
      }
    }

    return false;
  }
}
