<?php

namespace Club\TeamBundle\Listener;

class GenerateScheduleListener
{
  private $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onRepetitionChange(\Club\TeamBundle\Event\FilterRepetitionEvent $event)
  {
    $repetition = $event->getRepetition();
    // set start time
    $start = $repetition->getFirstDate();
    // set end time
    if ($repetition->getLastDate() != '') {
      $end = $repetition->getLastDate();
    } else {
      $end = new \DateTime();
      $end->add(new \DateInterval('P10Y'));
    }
    // set occurs
    $this->occur = 0;
    // get diff interval
    $diff = $repetition->getSchedule()->getFirstDate()->diff($repetition->getSchedule()->getEndDate());

    while ($start->getTimestamp() < $end->getTimestamp()) {
      switch ($repetition->getType()) {
      case 'daily':
        $this->addSchedule($start, $diff, $repetition);

        for ($i=1; $i < $repetition->getRepeatEvery(); $i++) {
          $start->add(new \DateInterval('P1D'));
          $this->deleteSchedule($start, $repetition);
        }
        $start->add(new \DateInterval('P1D'));
        break;
      case 'weekly':
        $curr_day = $start->format('N');
        while ($curr_day < 8) {
          if (in_array($start->format('N'), $repetition->getDaysInWeek())) {
            $this->addSchedule($start, $diff, $repetition);
          } else {
            $this->deleteSchedule($start, $repetition);
          }

          $curr_day++;
          $start->add(new \DateInterval('P1D'));
        }

        for ($i=0; $i < (($repetition->getRepeatEvery()-1)*7); $i++) {
          $start->add(new \DateInterval('P1D'));
          $this->deleteSchedule($start, $repetition);
        }
        break;
      case 'monthly':
        if ($repetition->getDayOfMonth()) {
          $this->addSchedule($start, $diff, $repetition);

          $t1 = clone $start;
          $start->add(new \DateInterval('P'.$repetition->getRepeatEvery().'M'));
          $t2 = clone $start;

        } else {

          if (!isset($init_time)) {
            $init_time = $start->getTimestamp();

            $temp = new \DateTime($repetition->getWeek().' '.$repetition->getSchedule()->getFirstDate()->format('D').' of '.$start->format('F Y'));
            $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));

            if ($init_time > $start->getTimestamp()) {
              $start->add(new \DateInterval('P1M'));
              $temp = new \DateTime($repetition->getWeek().' '.$repetition->getSchedule()->getFirstDate()->format('D').' of '.$start->format('F Y'));
              $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));
            }
          } else {
            $temp = new \DateTime($repetition->getWeek().' '.$repetition->getSchedule()->getFirstDate()->format('D').' of '.$start->format('F Y'));
            $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));
          }

          $this->addSchedule($start, $diff, $repetition);

          $t1 = clone $start;
          $start->add(new \DateInterval('P'.$repetition->getRepeatEvery().'M'));
          $temp = new \DateTime($repetition->getWeek().' '.$repetition->getSchedule()->getFirstDate()->format('D').' of '.$start->format('F Y'));
          $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));
          $t2 = clone $start;
        }

        $this->deleteBetween($t1, $repetition, $t2);
        break;
      case 'yearly':
        $this->addSchedule($start, $diff, $repetition);

        $t1 = clone $start;
        $start->add(new \DateInterval('P'.$repetition->getRepeatEvery().'Y'));
        $t2 = clone $start;

        $this->deleteBetween($t1, $repetition, $t2);
        break;
      }

      if ($this->occur > 25)
        break;
    }

    $this->deleteBetween($start, $repetition);
    $this->em->flush();
  }

  private function addSchedule(\DateTime $start, \DateInterval $diff, \Club\TeamBundle\Entity\Repetition $repetition)
  {
    $parent = ($repetition->getSchedule()->getSchedule()) ? $repetition->getSchedule()->getSchedule() : $repetition->getSchedule();

    $schedule = $this->em->createQueryBuilder()
      ->select('s')
      ->from('ClubTeamBundle:Schedule', 's')
      ->where('s.first_date = :date')
      ->andWhere('(s.schedule = :id OR s.id = :id)')
      ->setParameter('date', $start->format('Y-m-d H:i:s'))
      ->setParameter('id', $parent->getId())
      ->getQuery()
      ->getResult();

    $this->occur++;
    if (count($schedule))
      return;

    // find new times
    $new_format = $start->format('Y-m-d').' '.$repetition->getSchedule()->getFirstDate()->format('H:i:s');

    if ($new_format == $repetition->getSchedule()->getFirstDate()->format('Y-m-d H:i:s'))
      return;

    $new_first = new \DateTime($new_format);
    $new_end = new \DateTime($new_format);
    $new_end->add($diff);

    // make new schedule
    $schedule = new \Club\TeamBundle\Entity\Schedule();
    $schedule->setDescription($repetition->getSchedule()->getDescription());
    $schedule->setMaxAttend($repetition->getSchedule()->getMaxAttend());
    $schedule->setFirstDate($new_first);
    $schedule->setEndDate($new_end);
    $schedule->setTeam($repetition->getSchedule()->getTeam());
    $schedule->setLevel($repetition->getSchedule()->getLevel());
    $schedule->setLocation($repetition->getSchedule()->getLocation());
    $schedule->setSchedule($parent);

    $this->em->persist($schedule);

    return $schedule;
  }

  private function deleteSchedule(\DateTime $start, \Club\TeamBundle\Entity\Repetition $repetition)
  {
    $parent = ($repetition->getSchedule()->getSchedule()) ? $repetition->getSchedule()->getSchedule() : $repetition->getSchedule();

    $schedule = $this->em->createQueryBuilder()
      ->delete('ClubTeamBundle:Schedule', 's')
      ->where('s.first_date = :date')
      ->andWhere('s.schedule = :id')
      ->setParameter('date', $start->format('Y-m-d H:i:s'))
      ->setParameter('id', $parent->getId())
      ->getQuery()
      ->getResult();

    return true;
  }

  private function deleteBetween(\DateTime $start, \Club\TeamBundle\Entity\Repetition $repetition, \DateTime $end=null)
  {
    $parent = ($repetition->getSchedule()->getSchedule()) ? $repetition->getSchedule()->getSchedule() : $repetition->getSchedule();

    $qb = $this->em->createQueryBuilder()
      ->delete('ClubTeamBundle:Schedule', 's')
      ->where('s.schedule = :id')
      ->andWhere('s.first_date > :first')
      ->setParameter('first', $start->format('Y-m-d H:i:s'))
      ->setParameter('id', $parent->getId());

    if (isset($end))
      $qb->andWhere('s.first_date < :end')->setParameter('end', $end->format('Y-m-d H:i:s'));

    $qb->getQuery()->getResult();

    return true;
  }
}
