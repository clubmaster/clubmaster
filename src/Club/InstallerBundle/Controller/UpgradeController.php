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
    $configuration = $this->getMigrationsConfiguration();

    return array(
      'configuration' => $configuration
    );
  }

  /**
   * @Route("/upgrade/execute")
   * @Template()
   */
  public function upgradeAction()
  {
    $this->migrate();

    return array();
  }

  private function migrate()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $configuration = $this->getMigrationsConfiguration();
    $migration = new \Doctrine\DBAL\Migrations\Migration($configuration);

    $from = $configuration->getCurrentVersion();
    $to = $configuration->getLatestVersion();
    $migrations = $configuration->getMigrations();

    foreach ($migrations as $version) {
      if ($version->getVersion() > $from) {
        $migration->migrate($version->getVersion());
        $this->loadFixtures($version->getVersion());
      }
    }
  }

  private function loadFixtures($version)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $dir = $this->get('kernel')->getRootDir().'/DoctrineFixtures/'.$version;

    if (!file_exists($dir))
      return;

    $loader = new \Symfony\Bundle\DoctrineFixturesBundle\Common\DataFixtures\Loader($this->container);
    $loader->loadFromDirectory($dir);
    $fixtures = $loader->getFixtures();

    $purger = new  \Doctrine\Common\DataFixtures\Purger\ORMPurger($em);
    $executor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($em, $purger);

    $executor->execute($fixtures, true);
  }

  private function getMigrationsConfiguration()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $dir = $this->container->getParameter('doctrine_migrations.dir_name');
    $configuration = new \Doctrine\DBAL\Migrations\Configuration\Configuration($em->getConnection());
    $configuration->setMigrationsNamespace($this->container->getParameter('doctrine_migrations.namespace'));
    $configuration->setMigrationsDirectory($dir);
    $configuration->registerMigrationsFromDirectory($dir);
    $configuration->setName($this->container->getParameter('doctrine_migrations.name'));
    $configuration->setMigrationsTableName($this->container->getParameter('doctrine_migrations.table_name'));

    return $configuration;
  }
}
