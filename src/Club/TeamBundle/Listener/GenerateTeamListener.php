<?php

namespace Club\TeamBundle\Listener;

class GenerateTeamListener
{
  private $em;
  private $future_occurs;

  public function __construct($em, $future_occurs)
  {
    $this->em = $em;
    $this->future_occurs = $future_occurs;
  }

  public function onTeamTask(\Club\TaskBundle\Event\FilterTaskEvent $event)
  {
    $teams = $this->em->getRepository('ClubTeamBundle:Team')->getAllParent();
    foreach ($teams as $team) {
      $this->occur = 0;
      $this->future_occur = 0;

      $repetition = $team->getRepetition();
      if ($repetition) {
        $start = $repetition->getFirstDate();
        $this->generateTeams($team, $start);
      }
    }
  }

  public function onRepetitionChange(\Club\TeamBundle\Event\FilterRepetitionEvent $event)
  {
    $team = $event->getRepetition()->getTeam();
    $start = $team->getRepetition()->getFirstDate();

    $this->generateTeams($team, $start);
  }

  public function generateTeams(\Club\TeamBundle\Entity\Team $team, \DateTime $start)
  {
    // set end time
    if ($team->getRepetition()->getLastDate() != '') {
      $end = $team->getRepetition()->getLastDate();
    } else {
      $end = new \DateTime();
      $end->add(new \DateInterval('P10Y'));
    }
    // get diff interval
    $diff = $team->getFirstDate()->diff($team->getEndDate());

    while ($start->getTimestamp() <= $end->getTimestamp()) {
      switch ($team->getRepetition()->getType()) {
      case 'daily':
        $this->addTeam($start, $diff, $team);

        for ($i=1; $i < $team->getRepetition()->getRepeatEvery(); $i++) {
          $start->add(new \DateInterval('P1D'));
          $this->deleteTeam($start, $team);
        }
        $start->add(new \DateInterval('P1D'));
        break;
      case 'weekly':
        $curr_day = $start->format('N');
        while ($curr_day < 8) {
          if (in_array($start->format('N'), $team->getRepetition()->getDaysInWeek())) {
            $this->addTeam($start, $diff, $team);
          } else {
            $this->deleteTeam($start, $team);
          }

          $curr_day++;
          $start->add(new \DateInterval('P1D'));
        }

        for ($i=0; $i < (($team->getRepetition()->getRepeatEvery()-1)*7); $i++) {
          $start->add(new \DateInterval('P1D'));
          $this->deleteTeam($start, $team);
        }
        break;
      case 'monthly':
        if ($team->getRepetition()->getDayOfMonth()) {
          $this->addTeam($start, $diff, $team);

          $t1 = clone $start;
          $start->add(new \DateInterval('P'.$team->getRepetition()->getRepeatEvery().'M'));
          $t2 = clone $start;

        } else {

          if (!isset($init_time)) {
            $init_time = $start->getTimestamp();

            $temp = new \DateTime($team->getRepetition()->getWeek().' '.$team->getFirstDate()->format('D').' of '.$start->format('F Y'));
            $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));

            if ($init_time > $start->getTimestamp()) {
              $start->add(new \DateInterval('P1M'));
              $temp = new \DateTime($team->getRepetition()->getWeek().' '.$team->getFirstDate()->format('D').' of '.$start->format('F Y'));
              $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));
            }
          } else {
            $temp = new \DateTime($team->getRepetition()->getWeek().' '.$team->getFirstDate()->format('D').' of '.$start->format('F Y'));
            $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));
          }

          $this->addTeam($start, $diff, $team);

          $t1 = clone $start;
          $start->add(new \DateInterval('P'.$team->getRepetition()->getRepeatEvery().'M'));
          $temp = new \DateTime($team->getRepetition()->getWeek().' '.$team->getFirstDate()->format('D').' of '.$start->format('F Y'));
          $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));
          $t2 = clone $start;
        }

        $this->deleteBetween($t1, $team, $t2);
        break;
      case 'yearly':
        $this->addTeam($start, $diff, $team);

        $t1 = clone $start;
        $start->add(new \DateInterval('P'.$team->getRepetition()->getRepeatEvery().'Y'));
        $t2 = clone $start;

        $this->deleteBetween($t1, $team, $t2);
        break;
      }

      if ($this->future_occur >= $this->future_occurs)
        break;

      if ($team->getRepetition()->getEndOccurrences() > 0 & $this->occur >= $team->getRepetition()->getEndOccurrences())
        break;
    }

    $this->deleteBetween($start, $team);
    $this->em->flush();
  }

  private function addTeam(\DateTime $start, \DateInterval $diff, \Club\TeamBundle\Entity\Team $team)
  {
    // only count when we are in the future to get the following
    if ($start->getTimestamp() > time()) $this->future_occur++;
    $this->occur++;

    $parent = ($team->getTeam()) ? $team->getTeam() : $team;

    $res = $this->em->createQueryBuilder()
      ->select('s')
      ->from('ClubTeamBundle:Team', 's')
      ->where('s.first_date = :date')
      ->andWhere('(s.team = :id OR s.id = :id)')
      ->setParameter('date', $start->format('Y-m-d H:i:s'))
      ->setParameter('id', $parent->getId())
      ->getQuery()
      ->getResult();

    if (count($res))
      return;

    // find new times
    $new_format = $start->format('Y-m-d').' '.$team->getFirstDate()->format('H:i:s');

    if ($new_format == $team->getFirstDate()->format('Y-m-d H:i:s'))
      return;

    $new_first = new \DateTime($new_format);
    $new_end = new \DateTime($new_format);
    $new_end->add($diff);

    // make new team
    $new = new \Club\TeamBundle\Entity\Team();
    $new->setDescription($team->getDescription());
    $new->setMaxAttend($team->getMaxAttend());
    $new->setPenalty($team->getPenalty());
    $new->setFirstDate($new_first);
    $new->setEndDate($new_end);
    $new->setTeam($team->getTeam());
    $new->setLevel($team->getLevel());
    $new->setLocation($team->getLocation());
    $new->setTeam($parent);

    foreach ($team->getInstructors() as $instructor) {
      $new->addInstructor($instructor);
    }
    foreach ($team->getFields() as $field) {
      $new->addField($field);
    }

    $this->em->persist($new);

    return $new;
  }

  private function deleteTeam(\DateTime $start, \Club\TeamBundle\Entity\Team $team)
  {
    $parent = ($team->getTeam()) ? $team->getTeam() : $team;

    $team = $this->em->createQueryBuilder()
      ->delete('ClubTeamBundle:Team', 's')
      ->where('s.first_date = :date')
      ->andWhere('s.team = :id')
      ->setParameter('date', $start->format('Y-m-d H:i:s'))
      ->setParameter('id', $parent->getId())
      ->getQuery()
      ->getResult();

    return true;
  }

  private function deleteBetween(\DateTime $start, \Club\TeamBundle\Entity\Team $team, \DateTime $end=null)
  {
    $parent = ($team->getTeam()) ? $team->getTeam() : $team;

    $qb = $this->em->createQueryBuilder()
      ->delete('ClubTeamBundle:Team', 's')
      ->where('s.team = :id')
      ->andWhere('s.first_date > :first')
      ->setParameter('first', $start->format('Y-m-d H:i:s'))
      ->setParameter('id', $parent->getId());

    if (isset($end))
      $qb->andWhere('s.first_date < :end')->setParameter('end', $end->format('Y-m-d H:i:s'));

    $qb->getQuery()->getResult();

    return true;
  }
}
