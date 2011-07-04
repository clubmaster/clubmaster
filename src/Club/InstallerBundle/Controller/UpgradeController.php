<?php

namespace Club\InstallerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UpgradeController extends Controller
{
  /**
   * @Route("/upgrade")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $dir = $this->container->getParameter('doctrine_migrations.dir_name');
    $configuration = new \Doctrine\DBAL\Migrations\Configuration\Configuration($em->getConnection());
    $configuration->setMigrationsNamespace($this->container->getParameter('doctrine_migrations.namespace'));
    $configuration->setMigrationsDirectory($dir);
    $configuration->registerMigrationsFromDirectory($dir);
    $configuration->setName($this->container->getParameter('doctrine_migrations.name'));
    $configuration->setMigrationsTableName($this->container->getParameter('doctrine_migrations.table_name'));

    $migration = new \Doctrine\DBAL\Migrations\Migration($configuration);

    $from = $configuration->getCurrentVersion();
    $to = $configuration->getLatestVersion();
    $migrations = $configuration->getMigrations();

    foreach ($migrations as $version) {
      if ($version->getVersion() > $from)
        $migration->migrate($version->getVersion());
    }

    return array();
  }
}
