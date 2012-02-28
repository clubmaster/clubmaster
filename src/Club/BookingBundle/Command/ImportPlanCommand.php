<?php

namespace Club\BookingBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportPlanCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('club:import:plan')
      ->setDescription('Import booking plans')
      ->addArgument('file', InputArgument::REQUIRED, 'What filename to import')
      ->setHelp(<<<EOF
A short description of the required file format:

name
start date
stop date
EOF
      )
      ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $em = $this->getContainer()->get('doctrine.orm.entity_manager');

    $field_delimiter = "/\t/";
    $row_delimiter = "/\n/";

    $content = file_get_contents($input->getArgument('file'));
    $rows = preg_split($row_delimiter, $content);

    $field = $em->find('ClubBookingBundle:Field', 8);
    $user = $em->find('ClubUserBundle:User', 1);

    foreach ($rows as $line) {
      if (strlen($line) > 0) {
        list(
          $name,
          $start,
          $stop,
          $interval_start,
          $interval_stop,
          $day
        )  = preg_split($field_delimiter, $line);

        $day++;
        $start_time = new \DateTime($start.' 00:00:00');
        $stop_time = new \DateTime($stop.' 23:59:59');

        $t1 = new \DateTime(date('Y-m-d').' '.$interval_start);
        $t2 = new \DateTime(date('Y-m-d').' '.$interval_stop);

        $category = new \Club\BookingBundle\Entity\PlanCategory();
        $category->setName($name);
        $category->setDescription($name);
        $em->persist($category);

        $plan = new \Club\BookingBundle\Entity\Plan();
        $plan->setPlanCategory($category);
        $plan->setPeriodStart($start_time);
        $plan->setPeriodEnd($stop_time);
        $plan->setDay($day);
        $plan->setFirstDate($t1);
        $plan->setEndDate($t2);
        $plan->setUser($user);
        $plan->addField($field);

        $em->persist($plan);
      }
    }
    $em->flush();
  }
}
