<?php

namespace Club\InstallerBundle\Helper;

class Database
{
    private $container;
    private $em;

    public function __construct($container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.default_entity_manager');
    }

    public function migrate()
    {
        $conn = $this->container->get('database_connection');
        $files = $this->getNotInstalled();

        foreach ($files as $key => $file) {

            $sql = file_get_contents($file['filename']);
            $conn->query($sql);

            $vers = new \Club\InstallerBundle\Entity\MigrationVersion();
            $vers->setVersion($file['version']);

            $this->em->persist($vers);

            $event = new \Club\InstallerBundle\Event\FilterVersionEvent($vers);
            $this->container->get('event_dispatcher')->dispatch(\Club\InstallerBundle\Event\Events::onVersionMigrate, $event);
        }

        $this->em->flush();

        $this->container->get('event_dispatcher')->dispatch(\Club\InstallerBundle\Event\Events::onFixturesInit);
        $this->em->flush();
    }

    public function getCurrentVersion()
    {
        return $this->em->getRepository('ClubInstallerBundle:MigrationVersion')->getLatest();
    }

    public function getMigrations()
    {
        $files = $this->getMigrationFiles();

        foreach ($files as $key=>$file) {
            $files[$key]['is_upgraded'] = $this->isUpgraded($key);
        }

        return $files;
    }

    public function getNotInstalled()
    {
        $files = $this->getMigrations();
        foreach ($files as $key => $file) {
            if ($file['is_upgraded']) {
                unset($files[$key]);
            }
        }

        return $files;
    }

    private function isUpgraded($version)
    {
        try {
            $r = $this->em->getRepository('ClubInstallerBundle:MigrationVersion')->findOneBy(array(
                'version' => $version
            ));

            if ($r) return true;

            return false;
        } catch (\Doctrine\DBAL\DBALException $e) {
            return false;
        }
    }

    private function getMigrationFiles()
    {
        $root = $this->container->get('kernel')->getRootDir();
        $files = glob($root.'/database/mysql/*');

        $res = array();
        foreach ($files as $file) {
            if (preg_match("/version(\d+)\.sql$/", $file, $r)) {
                $res[$r[1]] = array(
                    'filename' => $file,
                    'version' => $r[1]
                );
            }
        }
        ksort($res);

        return $res;
    }
}
