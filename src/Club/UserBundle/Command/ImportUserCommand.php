<?php

namespace Club\UserBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportUserCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('club:import:user')
      ->setDescription('Import users')
      ->addArgument('file', InputArgument::REQUIRED, 'What filename to import')
      ->addOption('name_not_split', null, InputOption::VALUE_NONE, 'Is full name in firstname column?')
      ->addOption('dob_format', null, InputOption::VALUE_REQUIRED, 'Write syntax for birthday?','Y-m-d')
      ->addOption('field_delimiter', null, InputOption::VALUE_REQUIRED, 'Field delimiter', ',')
      ->addOption('row_delimiter', null, InputOption::VALUE_REQUIRED, 'Field delimiter', '\n')
      ->setHelp(<<<EOF
A short description of the required file format:

Member number
Password,
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
Day of birth
Gender
Created at (yyyy-mm-dd hh:ii:ss)
EOF
      )
      ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $em = $this->getContainer()->get('doctrine.orm.entity_manager');

    $content = file_get_contents($input->getArgument('file'));
    $rows = preg_split("/".$input->getOption('row_delimiter')."/", $content);

    foreach ($rows as $line) {
      if (strlen($line) > 0) {
        list(
          $member_number,
          $password,
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
          $dob,
          $gender,
          $created_at
        )  = preg_split("/".$input->getOption('field_delimiter')."/", $line);

        // clean data
        $first_name = preg_replace("/\"/", "", $first_name);
        $last_name = preg_replace("/\"/", "", $last_name);
        $dob = preg_replace("/\"/", "", $dob);
        $street = preg_replace("/\"/", "", $street);
        $phone = preg_replace("/\"/", "", $phone);

        $first_name = trim($first_name);
        $last_name = trim($last_name);

        if ($input->getOption('name_not_split')) {
          preg_match("/^(.*)\s(.*)?$/", $first_name, $o);
          $first_name = $o[1];
          $last_name = $o[2];
        }

        $gender = strtolower(trim($gender));
        $gender = preg_match("/^(male)$/", $gender) ? 'male' : 'female';

        $street = implode("\n", array($street, $street2));
        $phone = (preg_match("/^(|0)$/", $phone)) ? null : $phone;
        $email = trim($email);

        $dob = \DateTime::createFromFormat($input->getOption('dob_format'), $dob);

        $this->getContainer()->get('clubmaster.user')->buildUser();
        $user = $this->getContainer()->get('clubmaster.user')->get();

        $user->setPassword($password);
        if ($member_number > 0) $user->setMemberNumber($member_number);

        $profile = $user->getProfile();
        $profile->setFirstName($first_name);
        $profile->setLastName($last_name);
        $profile->setDayOfBirth($dob);
        $profile->setGender($gender);

        $p_address = $profile->getProfileAddress();
        $p_address->setStreet($street);
        $p_address->setPostalCode($postalcode);
        $p_address->setCity($city);
        $p_address->setCountry($country);

        if (!strlen($phone)) {
          $profile->setProfilePhone(null);
        } else {
          $p_phone = $profile->getProfilePhone();
          $p_phone->setPhoneNumber($phone);
        }

        if (!strlen($email)) {
          $profile->setProfileEmail(null);
        } else {
          $p_email = $profile->getProfileEmail();
          $p_email->setEmailAddress($email);
        }

        $em->persist($user);
        $em->flush();
      }
    }
  }
}
