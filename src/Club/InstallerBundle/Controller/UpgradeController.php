<?php

namespace Club\InstallerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/installer")
 */
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

    $to = $configuration->getLatestVersion();
    $migrations = $configuration->getMigrations();
    $migration->migrate($to);

    $this->get('event_dispatcher')->dispatch(\Club\InstallerBundle\Event\Events::onFixturesInit);
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
