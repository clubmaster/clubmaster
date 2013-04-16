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
  protected $schedule;
  protected $schedule_user;

  public function __construct(EntityManager $em, $container, $security_context, $validator)
  {
    $this->em = $em;
    $this->container = $container;
    $this->security_context = $security_context;
    $this->validator = $validator;
  }

  public function bindUnattend(\Club\TeamBundle\Entity\Schedule $schedule, \Club\UserBundle\Entity\User $user)
  {
    $this->schedule = $schedule;
    $this->user = $user;

    if ($this->security_context->isGranted('ROLE_TEAM_ADMIN'))

      return;

    if ($this->security_context->getToken()->getUser() != $user) {
      $this->setError('You do not have permissions to unattend this team');

      return;
    }

    $book_time = clone $this->schedule->getFirstDate();

    $now = new \DateTime();
    if ($book_time < $now) {
      $this->setError('You cannot unattend teams in the past');

      return;
    }

    $attend = $this->em->getRepository('ClubTeamBundle:ScheduleUser')->findOneBy(array(
      'user' => $this->user->getId(),
      'schedule' => $this->schedule->getId()
    ));

    $diff = ($now->getTimestamp()-$attend->getCreatedAt()->getTimestamp());
    if ($diff < $this->container->getParameter('club_team.cancel_minute_created')*60)

      return;

    $delete_within = clone $book_time;
    $delete_within->sub(new \DateInterval('PT'.$this->container->getParameter('club_team.cancel_minute_before').'M'));
    if ($delete_within < new \DateTime())
      $this->setError('Cannot unattend team because time range is too small');
  }

  public function bindAttend(\Club\TeamBundle\Entity\Schedule $schedule, \Club\UserBundle\Entity\User $user)
  {
    $this->schedule = $schedule;
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
    $this->schedule_user = new \Club\TeamBundle\Entity\ScheduleUser();
    $this->schedule_user->setUser($this->user);
    $this->schedule_user->setSchedule($this->schedule);

    $errors = $this->validator->validate($this->schedule_user, array('attend'));
    foreach ($errors as $error) {
      $this->setError($error->getMessage());

      return;
    }
  }

  public function save()
  {
    $this->em->persist($this->schedule_user);
    $this->em->flush();

    return $this->schedule_user;
  }

  public function remove()
  {
    $res = $this->em->getRepository('ClubTeamBundle:ScheduleUser')->findOneBy(array(
      'user' => $this->user->getId(),
      'schedule' => $this->schedule->getId()
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
    $c = clone $this->schedule->getFirstDate();

    if ($c < new \DateTime()) {
      $this->setError('You cannot attend in the past');
      return;
    }

    $r = $this->em->createQueryBuilder()
      ->select('su')
      ->from('ClubTeamBundle:ScheduleUser','su')
      ->where('su.schedule = :schedule')
      ->andWhere('su.user = :user')
      ->setParameter('schedule', $this->schedule->getId())
      ->setParameter('user', $this->user->getId())
      ->getQuery()
      ->getOneOrNullResult();

    if (count($r)) {
      $this->setError('You are already on this team');
      return;
    }

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(su)')
      ->from('ClubTeamBundle:ScheduleUser', 'su')
      ->leftJoin('su.schedule', 's')
      ->where('s.first_date > :first')
      ->andWhere('s.first_date < :end')
      ->andWhere('su.user = :user')
      ->setParameter('user', $this->user->getId())
      ->setParameter('first', $this->schedule->getFirstDate()->format('Y-m-d').' 00:00:00')
      ->setParameter('end', $this->schedule->getFirstDate()->format('Y-m-d').' 23:59:59')
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_team.num_team_day')) {
      $this->setError('You cannot attend more teams this day');
      return;
    }

    $res = $this->em->createQueryBuilder()
      ->select('COUNT(su)')
      ->from('ClubTeamBundle:ScheduleUser', 'su')
      ->leftJoin('su.schedule', 's')
      ->where('s.first_date >= CURRENT_DATE()')
      ->andWhere('su.user = :user')
      ->setParameter('user', $this->user->getId())
      ->getQuery()
      ->getSingleResult();

    if ($res[1] >= $this->container->getParameter('club_team.num_team_future')) {
      $this->setError('You cannot attend more teams');
      return;
    }

    $subs = $this->em->getRepository('ClubShopBundle:Subscription')->getActiveSubscriptions($this->user, null, 'team');
    if (!$subs) {
        $this->setError('No subscription for teams');
        return;
    }

    foreach ($subs as $subscription) {
        if ($subscription->getType() == 'ticket' && $subscription->getSubscriptionTicket()->getTickets() <= 0) {
            $this->setError('No subscription for teams');

            return;
        }
    }

    $this->prepare();
  }

  private function hasSubscription(\Club\UserBundle\Entity\User $user)
  {
    foreach ($user->getSubscriptions() as $subscription) {
      if ($subscription->hasAttribute('team')) {
        foreach ($subscription->getLocation() as $location) {

          if ($location == $this->schedule->getLocation()) {
            $this->users[] = $user;

            return true;
          }

          foreach ($subscription->getLocation() as $child) {
            if ($child == $this->schedule->getLocation()) {
              $this->users[] = $user;

              return true;
            }

            foreach ($child->getChilds() as $child2) {
              if ($child2 == $this->schedule->getLocation()) {
                $this->users[] = $user;

                return true;
              }
            }

            foreach ($child2->getChilds() as $child3) {
              if ($child3 == $this->schedule->getLocation()) {
                $this->users[] = $user;

                return true;
              }

              foreach ($child3->getChilds() as $child4) {
                if ($child4 == $this->schedule->getLocation()) {
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
