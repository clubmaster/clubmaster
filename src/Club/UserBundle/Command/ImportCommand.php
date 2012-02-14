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
Day of birth (yyyy-mm-dd)
Gender
Created at (yyyy-mm-dd hh:ii:ss)
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
          $day_of_birth,
          $gender,
          $created_at
        )  = preg_split($field_delimiter, $line);

        // clean data
        $first_name = trim($first_name);
        $last_name = trim($last_name);

        $gender = strtolower(trim($gender));
        $gender = preg_match("/^(male)$/", $gender) ? 'male' : 'female';

        $street = implode("\n", array($street, $street2));
        $phone = (preg_match("/^(|0)$/", $phone)) ? null : $phone;
        $email = trim($email);

        $country_ng = $em->getRepository('ClubUserBundle:Country')->findOneBy(array( 'country' => $country ));
        if (!$country_ng) throw new \Exception('No country: '.$country);
        // end cleanup

        $this->getContainer()->get('clubmaster.user')->buildUser();
        $user = $this->getContainer()->get('clubmaster.user')->get();

        $user->setPassword($password);
        if ($member_number > 0) $user->setMemberNumber($member_number);

        $profile = $user->getProfile();
        $profile->setFirstName($first_name);
        $profile->setLastName($last_name);
        $profile->setDayOfBirth(new \DateTime($day_of_birth));
        $profile->setGender($gender);

        $p_address = $profile->getProfileAddress();
        $p_address->setStreet($street);
        $p_address->setPostalCode($postalcode);
        $p_address->setCity($city);
        $p_address->setCountry($country_ng);

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
      }
    }
    $em->flush();
  }
}
