<?php

namespace Club\TeamBundle\Listener;

class GenerateScheduleListener
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
    $schedules = $this->em->getRepository('ClubTeamBundle:Schedule')->getAllParent();
    foreach ($schedules as $schedule) {
      $this->occur = 0;
      $this->future_occur = 0;

      $repetition = $schedule->getRepetition();
      if ($repetition) {
        $start = $repetition->getFirstDate();
        $this->generateSchedules($schedule, $start);
      }
    }
  }

  public function onRepetitionChange(\Club\TeamBundle\Event\FilterRepetitionEvent $event)
  {
    $schedule = $event->getRepetition()->getSchedule();
    $start = $schedule->getRepetition()->getFirstDate();

    $this->generateSchedules($schedule, $start);
  }

  public function generateSchedules(\Club\TeamBundle\Entity\Schedule $schedule, \DateTime $start)
  {
    // set end time
    if ($schedule->getRepetition()->getLastDate() != '') {
      $end = $schedule->getRepetition()->getLastDate();
    } else {
      $end = new \DateTime();
      $end->add(new \DateInterval('P10Y'));
    }
    // get diff interval
    $diff = $schedule->getFirstDate()->diff($schedule->getEndDate());

    while ($start->getTimestamp() <= $end->getTimestamp()) {
      switch ($schedule->getRepetition()->getType()) {
      case 'daily':
        $this->addSchedule($start, $diff, $schedule);

        for ($i=1; $i < $schedule->getRepetition()->getRepeatEvery(); $i++) {
          $start->add(new \DateInterval('P1D'));
          $this->deleteSchedule($start, $schedule);
        }
        $start->add(new \DateInterval('P1D'));
        break;
      case 'weekly':
        $curr_day = $start->format('N');
        while ($curr_day < 8) {
          if (in_array($start->format('N'), $schedule->getRepetition()->getDaysInWeek())) {
            $this->addSchedule($start, $diff, $schedule);
          } else {
            $this->deleteSchedule($start, $schedule);
          }

          $curr_day++;
          $start->add(new \DateInterval('P1D'));
        }

        for ($i=0; $i < (($schedule->getRepetition()->getRepeatEvery()-1)*7); $i++) {
          $start->add(new \DateInterval('P1D'));
          $this->deleteSchedule($start, $schedule);
        }
        break;
      case 'monthly':
        if ($schedule->getRepetition()->getDayOfMonth()) {
          $this->addSchedule($start, $diff, $schedule);

          $t1 = clone $start;
          $start->add(new \DateInterval('P'.$schedule->getRepetition()->getRepeatEvery().'M'));
          $t2 = clone $start;

        } else {

          if (!isset($init_time)) {
            $init_time = $start->getTimestamp();

            $temp = new \DateTime($schedule->getRepetition()->getWeek().' '.$schedule->getFirstDate()->format('D').' of '.$start->format('F Y'));
            $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));

            if ($init_time > $start->getTimestamp()) {
              $start->add(new \DateInterval('P1M'));
              $temp = new \DateTime($schedule->getRepetition()->getWeek().' '.$schedule->getFirstDate()->format('D').' of '.$start->format('F Y'));
              $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));
            }
          } else {
            $temp = new \DateTime($schedule->getRepetition()->getWeek().' '.$schedule->getFirstDate()->format('D').' of '.$start->format('F Y'));
            $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));
          }

          $this->addSchedule($start, $diff, $schedule);

          $t1 = clone $start;
          $start->add(new \DateInterval('P'.$schedule->getRepetition()->getRepeatEvery().'M'));
          $temp = new \DateTime($schedule->getRepetition()->getWeek().' '.$schedule->getFirstDate()->format('D').' of '.$start->format('F Y'));
          $start = new \DateTime($temp->format('Y-m-d').' '.$start->format('H:i:s'));
          $t2 = clone $start;
        }

        $this->deleteBetween($t1, $schedule, $t2);
        break;
      case 'yearly':
        $this->addSchedule($start, $diff, $schedule);

        $t1 = clone $start;
        $start->add(new \DateInterval('P'.$schedule->getRepetition()->getRepeatEvery().'Y'));
        $t2 = clone $start;

        $this->deleteBetween($t1, $schedule, $t2);
        break;
      }

      if ($this->future_occur >= $this->future_occurs)
        break;

      if ($schedule->getRepetition()->getEndOccurrences() > 0 & $this->occur >= $schedule->getRepetition()->getEndOccurrences())
        break;
    }

    $this->deleteBetween($start, $schedule);
    $this->em->flush();
  }

  private function addSchedule(\DateTime $start, \DateInterval $diff, \Club\TeamBundle\Entity\Schedule $schedule)
  {
    // only count when we are in the future to get the following
    if ($start->getTimestamp() > time()) $this->future_occur++;
    $this->occur++;

    $parent = ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;

    $res = $this->em->createQueryBuilder()
      ->select('s')
      ->from('ClubTeamBundle:Schedule', 's')
      ->where('s.first_date = :date')
      ->andWhere('(s.schedule = :id OR s.id = :id)')
      ->setParameter('date', $start->format('Y-m-d H:i:s'))
      ->setParameter('id', $parent->getId())
      ->getQuery()
      ->getResult();

    if (count($res))
      return;

    // find new times
    $new_format = $start->format('Y-m-d').' '.$schedule->getFirstDate()->format('H:i:s');

    if ($new_format == $schedule->getFirstDate()->format('Y-m-d H:i:s'))
      return;

    $new_first = new \DateTime($new_format);
    $new_end = new \DateTime($new_format);
    $new_end->add($diff);

    // make new schedule
    $new = new \Club\TeamBundle\Entity\Schedule();
    $new->setDescription($schedule->getDescription());
    $new->setMaxAttend($schedule->getMaxAttend());
    $new->setPenalty($schedule->getPenalty());
    $new->setFirstDate($new_first);
    $new->setEndDate($new_end);
    $new->setTeamCategory($schedule->getTeamCategory());
    $new->setLevel($schedule->getLevel());
    $new->setLocation($schedule->getLocation());
    $new->setSchedule($parent);

    foreach ($schedule->getInstructors() as $instructor) {
      $new->addInstructor($instructor);
    }
    foreach ($schedule->getFields() as $field) {
      $new->addField($field);
    }

    $this->em->persist($new);

    return $new;
  }

  private function deleteSchedule(\DateTime $start, \Club\TeamBundle\Entity\Schedule $schedule)
  {
    $parent = ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;

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

  private function deleteBetween(\DateTime $start, \Club\TeamBundle\Entity\Schedule $schedule, \DateTime $end=null)
  {
    $parent = ($schedule->getSchedule()) ? $schedule->getSchedule() : $schedule;

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
