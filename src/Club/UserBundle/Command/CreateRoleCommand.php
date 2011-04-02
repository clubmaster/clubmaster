<?php

namespace Club\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Club\UserBundle\Entity\Role;

class CreateRoleCommand extends Command
{
  protected function configure()
  {
    $this
      ->setName('club:role:create')
      ->setDescription('Create a role')
      ->setDefinition(array(
        new InputArgument('role', InputArgument::REQUIRED,' The role'),
      ))
      ->setHelp(<<<EOF
The <info>club:role:create</info> command creates a role:

  <info>php app/console club:user:create role</info>

EOF
    );
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $em = $this->container->get('doctrine.orm.entity_manager');

    $role = new Role();
    $role->setRoleName($input->getArgument('role'));

    $em->persist($role);
    $em->flush();

    $output->writeln(sprintf('Created role <command>%s</command>',$role->getRole()));
  }
}
