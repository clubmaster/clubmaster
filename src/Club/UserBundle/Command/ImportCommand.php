<?php

namespace Club\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('club:import:user')
      ->setDescription('Import users')
      ->addArgument('file', InputArgument::REQUIRED, 'What filename to import')
      ->setHelp(<<<EOF
A should description of the required file format is:

Member number
First name
Last name
Street
Street 2
Postalcode
City
Country
Phone
Phone 2
Email
Day of birth (yyyy-mm-dd)
Gender
Created at (yyyy-mm-dd hh:ii:ss)
EOF
      )
      ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $field_delimiter = "/\t/";
    $row_delimiter = "/\n/";

    $content = file_get_contents($input->getArgument('file'));
    $rows = preg_split($row_delimiter, $content);

    foreach ($rows as $line) {
      if (strlen($line) > 0) {
        list(
          $member_number,
          $first_name,
          $last_name,
          $street,
          $street2,
          $postalcode,
          $city,
          $country,
          $phone,
          $phone2,
          $email,
          $day_of_birth,
          $gender,
          $created_at
        )  = preg_split($field_delimiter, $line);

        $gender = strtolower(trim($gender));
        $gender = preg_match("/^(male)$/", $gender) ? 'male' : 'female';

        $user = $this->getContainer()->get('clubmaster.user')->buildUser();
        if ($member_number > 0) $user->setMemberNumber($member_number);

        $profile = $user->getProfile();
        $profile->setFirstName($first_name);
        $profile->setLastName($last_name);
        $profile->setDayOfBirth(new \DateTime($day_of_birth));
        $profile->setGender($gender);

        $this->em->persist($user);
      }
    }
    $this->em->flush();
  }
}
