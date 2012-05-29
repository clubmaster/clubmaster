<?php

namespace Club\UserBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class UpdatePasswordCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('club:user:password')
      ->setDescription('Update passwords')
      ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $em = $this->getContainer()->get('doctrine.orm.entity_manager');

    $users = $em->getRepository('ClubUserBundle:User')->findAll();

    foreach ($users as $user) {
      $password = $user->getProfile()->getDayOfBirth()->format('dmy');
      $user->setPassword($password);
      $em->persist($user);
    }

    $em->flush();
  }
}
