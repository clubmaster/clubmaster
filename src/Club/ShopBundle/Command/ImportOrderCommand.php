<?php

namespace Club\ShopBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportOrderCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('club:import:order')
      ->setDescription('Import orders')
      ->addArgument('file', InputArgument::REQUIRED, 'What filename to import')
      ->addArgument('product', InputArgument::REQUIRED, 'What product id to let the users buy?')
      ->setHelp(<<<EOF
The required filename just has to have a list of member numbers.
EOF
      )
      ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $em = $this->getContainer()->get('doctrine.orm.entity_manager');

    $fh = fopen($input->getArgument('file'));
    while (!feof($fh)) {
      $member_number = trim(fgets($fh, 1024));

      $user = $em->getRepository('ClubUserBundle:User')->findOneBy(array(
        'member_number' => $member_number
      ));

      if (!$user) throw new \Exception('No such user: '.$member_number);
    }
    $em->flush();
  }
}
