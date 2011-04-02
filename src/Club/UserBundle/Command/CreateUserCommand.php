<?php

namespace Club\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Club\UserBundle\Entity\UserManager;

class CreateUserCommand extends Command
{
  protected function configure()
  {
    $this
      ->setName('club:user:create')
      ->setDescription('Create a user')
      ->setDefinition(array(
        new InputArgument('username', InputArgument::REQUIRED,' The username'),
        new InputArgument('password', InputArgument::REQUIRED, 'The password'),
        new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the user as super admin'),
        new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
      ))
      ->setHelp(<<<EOF
The <info>club:user:create</info> command creates a user:

You can specify the password as the second arguments:

  <info>php app/console club:user:create matthieu mypassword</info>

You can create a super admin via the super-admin flag:

  <info>php app/console club:user:create admin --super-admin</info>

You can create an inactive user (will not be able to log in):

  <info>php app/console club:user:create thibault --inactive</info>

EOF
    );
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $um = new UserManager($this->container->get('doctrine.orm.entity_manager'));
    $user = $um->createUser();

    $user->setUsername($input->getArgument('username'));
    $user->setEnabled($input->getOption('inactive'));

    $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
    $password = $encoder->encodePassword($input->getArgument('password'), $user->getSalt());
    $user->setPassword($password);

    $um->updateUser($user);


    $output->writeln(sprintf('Created user <command>%s</command>',$user->getUsername()));
  }
}
