<?php

namespace Club\InstallerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/upgrade")
 */
class UpgradeController extends Controller
{
    /**
     * @Route("")
     * @Template()
     */
    public function indexAction()
    {
        $d = $this->get('club_installer.database');

        $v = $this->getDoctrine()->getEntityManager()->find('ClubInstallerBundle:MigrationVersion', 2);
        $event = new \Club\InstallerBundle\Event\FilterVersionEvent($v);
        $this->get('event_dispatcher')->dispatch(\Club\InstallerBundle\Event\Events::onVersionMigrate, $event);

        return array(
            'current_version' => $d->getCurrentVersion()->getVersion(),
            'migrations' => $d->getMigrations(),
            'not_installed' => $d->getNotInstalled()
        );
    }

    /**
     * @Route("/migrate")
     * @Template()
     */
    public function migrateAction()
    {
        $d = $this->get('club_installer.database');

        try {
            $d->migrate();
            $this->get('session')->setFlash('notice', 'Your database is now upgraded.');

        } catch (\Exception $e) {
            $this->get('logger')->err($e->getMessage());
            $this->get('session')->setFlash('error', $e->getMessage());
        }

        return $this->redirect($this->generateUrl('club_installer_upgrade_index'));
    }
}
