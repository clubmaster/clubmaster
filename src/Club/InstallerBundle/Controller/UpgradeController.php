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
        $this->setIni();
        $d = $this->get('club_installer.database');

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
        $this->setIni();
        $d = $this->get('club_installer.database');

        try {
            $d->migrate();
            $this->get('session')->getFlashBag()->add('notice', 'Your database is now upgraded.');

        } catch (\Exception $e) {
            $this->get('logger')->err($e->getMessage());
            $this->get('session')->getFlashBag()->add('error', $e->getMessage());
        }

        return $this->redirect($this->generateUrl('club_installer_upgrade_index'));
    }

    private function setIni()
    {
        ini_set('max_execution_time', 600);
    }
}
