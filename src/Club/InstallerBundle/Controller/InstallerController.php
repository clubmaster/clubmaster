<?php

namespace Club\InstallerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

/**
 * @Route("/installer")
 */
class InstallerController extends Controller
{
    /**
     * @Route("/parameter")
     * @Template()
     */
    public function parameterAction()
    {
        $this->validateInstaller();

        if ($this->getRequest()->getMethod() == 'POST') {
            try {
                $em = $this->getDoctrine()->getEntityManager();
                $user = $em->find('ClubUserBundle:User', 1);

            } catch (\PDOException $e) {
                // only if we have a PDO exception, which is connection error
                $this->get('session')->setFlash('error', $e->getMessage());
            } catch (\Doctrine\DBAL\DBALException $e) {
            }

            $response = $this->redirect($this->generateUrl('club_installer_installer_migrate'));

            $this->get('club_installer.installer')->clearCache();

            return $response;
        }

        $config = unserialize($this->get('session')->get('installer'));
        $params = array(
            'database_driver' => $config->driver,
            'database_host' => $config->host,
            'database_port' => $config->port,
            'database_name' => $config->name,
            'database_user' => $config->user,
            'database_password' => $config->password,
            'mailer_transport' => 'smtp',
            'mailer_host' => 'localhost',
            'mailer_user' => null,
            'mailer_password' => null,
            'locale' => 'en',
            'secret' => $config->secret
        );

        return array(
            'parameters' => Yaml::dump(array('parameters' => $params))
        );
    }

    /**
     * @Route("/config")
     * @Template()
     */
    public function configAction()
    {
        $this->validateInstaller();

        $config = new \Club\InstallerBundle\Step\DoctrineStep();
        $form = $this->createForm(new \Club\InstallerBundle\Form\DoctrineStepType(), $config);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $this->get('session')->set('installer', serialize($config));

                return $this->redirect($this->generateUrl('club_installer_installer_parameter'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("")
     * @Template()
     */
    public function indexAction()
    {
        $this->validateInstaller();

        $this->get('session')->set('installer_user_id',null);
        $this->get('session')->set('installer_location_id',null);

        return array();
    }

    /**
     * @Route("/step/1")
     * @Template()
     */
    public function databaseAction()
    {
        $this->validateInstaller();

        return array();
    }

    /**
     * @Route("/step/2")
     * @Template()
     */
    public function administratorAction()
    {
        $this->validateInstaller();

        $em = $this->getDoctrine()->getEntityManager();

        if ($this->get('session')->get('installer_user_id')) {
            $user = $em->find('ClubUserBundle:User',$this->get('session')->get('installer_user_id'));
        } else {
            $user = $this->get('clubmaster.user')->get();
            $user->getProfile()->setProfileAddress(null);
            $user->getProfile()->setProfilePhone(null);
        }

        $form = $this->createForm(new \Club\InstallerBundle\Form\AdministratorStep(), $user);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $group = $em->getRepository('ClubUserBundle:Group')->findOneBy(array(
                    'group_name' => 'Super Administrators'
                ));

                $group->addUsers($user);

                $this->get('clubmaster.user')->save();

                $this->get('session')->set('installer_user_id',$user->getId());

                return $this->redirect($this->generateUrl('club_installer_installer_location'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/step/3")
     * @Template()
     */
    public function locationAction()
    {
        $this->validateInstaller();

        $em = $this->getDoctrine()->getEntityManager();

        $location_step = new \Club\InstallerBundle\Step\LocationStep();
        $form = $this->createForm(new \Club\InstallerBundle\Form\LocationStep(), $location_step);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $location = new \Club\UserBundle\Entity\Location();
                $location->setLocationName($location_step->location_name);
                $location->setClub(true);
                $em->persist($location);

                $lc = new \Club\UserBundle\Entity\LocationConfig();
                $lc->setConfig('default_currency');
                $lc->setLocation($location);
                $lc->setValue($location_step->currency->getId());
                $em->persist($lc);
                $lc = new \Club\UserBundle\Entity\LocationConfig();
                $lc->setConfig('email_sender_address');
                $lc->setLocation($location);
                $lc->setValue('noreply@clubmaster.org');
                $em->persist($lc);
                $lc = new \Club\UserBundle\Entity\LocationConfig();
                $lc->setConfig('email_sender_name');
                $lc->setLocation($location);
                $lc->setValue('ClubMaster Administrator');
                $em->persist($lc);

                $em->flush();

                $this->get('session')->set('installer_location_id', $location->getId());

                return $this->redirect($this->generateUrl('club_installer_installer_confirm'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/step/4")
     * @Template()
     */
    public function confirmAction()
    {
        $this->validateInstaller();

        return array();
    }

    /**
     * @Route("/migrate")
     * @Template()
     */
    public function migrateAction()
    {
        try {
            $this->validateInstaller();

            $this->get('club_installer.database')->migrate();

            $this->get('session')->setFlash('notice', 'Database was successful installed');

            return $this->redirect($this->generateUrl('club_installer_installer_administrator'));
        } catch (\Exception $e) {
            $this->get('session')->setFlash('error', $e->getMessage());
            return $this->redirect($this->generateUrl('club_installer_installer_parameter'));
        }
    }

    private function validateInstaller()
    {
        if (!$this->container->get('club_installer.installer')->installerOpen()) {
            throw new \Exception('Installer is not open');
        }
    }
}
