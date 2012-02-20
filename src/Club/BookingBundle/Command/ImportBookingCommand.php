<?php

namespace Club\BookingBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportBookingCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('club:import:booking')
      ->setDescription('Import bookings')
      ->addArgument('file', InputArgument::REQUIRED, 'What filename to import')
      ->setHelp(<<<EOF
A short description of the required file format:

booker member number
partner member number
field
book date
start time
stop time
EOF
      )
      ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    // this list is used to translate foreign field id to local
    $foreign = array(
      '/1/',
      '/2/',
      '/3/',
      '/4/',
      '/5/',
      '/6/',
      '/7/',
      '/8/',
      '/9/',
      '/10/',
      '/11/',
      '/12/',
      '/13/',
      '/14/',
      '/15/',
      '/16/',
      '/17/',
      '/18/',
      '/19/',
      '/20/',
      '/21/',
      '/22/',
      '/23/',
      '/24/');

    $local = array(
      1,
      2,
      3,
      4,
      5,
      6,
      7,
      8,
      1,
      2,
      3,
      4,
      5,
      6,
      7,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      null,
      8);

    $em = $this->getContainer()->get('doctrine.orm.entity_manager');

    $field_delimiter = "/\t/";
    $row_delimiter = "/\n/";
    $guest_number = '9998';

    $content = file_get_contents($input->getArgument('file'));
    $rows = preg_split($row_delimiter, $content);

    foreach ($rows as $line) {
      if (strlen($line) > 0) {
        list(
          $member_number,
          $partner_number,
          $field,
          $date,
          $start,
          $stop,
        )  = preg_split($field_delimiter, $line);

        $field_id = preg_replace($foreign, $local, $field);

        $start_time = new \DateTime($date.' '.$start);
        $stop_time = new \DateTime($date.' '.$stop);
        $guest = ($partner_number == $guest_number) ? true : false;

        $field = $em->find('ClubBookingBundle:Field', $field_id);

        $user = $em->getRepository('ClubUserBundle:User')->findOneBy(array( 'member_number' => $member_number ));
        if (!$user) throw new \Exception('No such user: '.$member_number);

        if (!$guest) {
          $partner = $em->getRepository('ClubUserBundle:User')->findOneBy(array( 'member_number' => $partner_number ));
          if (!$partner) throw new \Exception('No such user: '.$partner_number);
        } else {
          $partner = false;
        }

        $booking = new \Club\BookingBundle\Entity\Booking();
        $booking->setFirstDate($start_time);
        $booking->setEndDate($stop_time);
        $booking->setField($field);
        $booking->setUser($user);
        $booking->setGuest($guest);

        if ($partner) $booking->addUser($partner);

        $em->persist($booking);
      }
    }
    $em->flush();
  }
}
