<?php

namespace Club\InstallerBundle\Helper;

class Database
{
  private $container;

  public function __construct($container)
  {
    $this->container = $container;
  }

  public function migrate()
  {
    $em = $this->container->get('doctrine.orm.entity_manager');
    $conn = $this->container->get('database_connection');

    $root = $this->container->get('kernel')->getRootDir();
    $files = glob($root.'/database/mysql/*');
    $res = array();
    foreach ($files as $file) {
      if (preg_match("/version(\d+)\.sql$/", $file, $r)) {
        $res[$r[1]] = $file;
      }
    }

    foreach ($res as $version => $file) {
      try {
        $r = $em->getRepository('ClubInstallerBundle:MigrationVersion')->findOneBy(array(
          'version' => $version
        ));
      } catch (\Exception $e) {
        $r = false;
      }

      if (!$r) {
        $sql = file_get_contents($file);
        $conn->query($sql);

        $vers = new \Club\InstallerBundle\Entity\MigrationVersion();
        $vers->setVersion($version);

        $em->persist($vers);
      }
    }

    $em->flush();
    $this->container->get('event_dispatcher')->dispatch(\Club\InstallerBundle\Event\Events::onFixturesInit);
  }
}
