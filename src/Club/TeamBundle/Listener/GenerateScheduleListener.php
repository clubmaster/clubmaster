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
        $start->add(new \DateInterval('P'.$repetition->getRepeatEvery().'D'));
        break;
      case 'weekly':
        if (in_array($start->format('N'), $repetition->getDaysInWeek()))
          $this->addSchedule($start, $diff, $repetition);

        $start->add(new \DateInterval('P'.$repetition->getRepeatEvery().'D'));
        break;
      case 'monthly':
        if ($repetition->getDayOfMonth()) {
          $this->addSchedule($start, $diff, $repetition);
        } else {
          $temp = new \DateTime($repetition->getWeek().' '.$repetition->getSchedule()->getFirstDate()->format('D').' of '.$start->format('F Y'));
          $this->addSchedule($temp, $diff, $repetition);
        }

        $start->add(new \DateInterval('P'.$repetition->getRepeatEvery().'M'));
        break;
      case 'yearly':
        $this->addSchedule($start, $diff, $repetition);
        $start->add(new \DateInterval('P'.$repetition->getRepeatEvery().'Y'));
        break;
      }

      if ($this->occur > 25)
        break;
    }

    $this->em->flush();
    die('marm');
  }

  private function addSchedule(\DateTime $start, \DateInterval $diff, \Club\TeamBundle\Entity\Repetition $repetition)
  {
    // find new times
    $new_format = $start->format('Y-m-d').' '.$repetition->getSchedule()->getFirstDate()->format('H:i:s');

    if ($new_format == $repetition->getSchedule()->getFirstDate()->format('Y-m-d H:i:s'))
      return;

    echo $start->format('Y-m-d H:i:s');echo "<br>";
    $new_first = new \DateTime($new_format);
    $new_end = new \DateTime($new_format);
    $new_end->add($diff);

    // make new schedule
    $schedule = new \Club\TeamBundle\Entity\Schedule();
    $schedule->setDescription($repetition->getSchedule()->getDescription());
    $schedule->setFirstDate($new_first);
    $schedule->setEndDate($new_end);
    $schedule->setTeam($repetition->getSchedule()->getTeam());
    $schedule->setLevel($repetition->getSchedule()->getLevel());
    $schedule->setSchedule($repetition->getSchedule());

    $this->em->persist($schedule);
    $this->occur++;

    return $schedule;
  }
}
