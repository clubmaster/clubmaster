<?php

namespace Club\InstallerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InstallerController extends Controller
{
  /**
   * @Route("/installer")
   * @Template()
   */
  public function indexAction()
  {
    return array();
  }

  /**
   * @Route("/installer/step/1")
   * @Template()
   */
  public function databaseAction()
  {
    $step = new \Club\InstallerBundle\Step\DatabaseStep();
    $form = $this->createForm(new \Club\InstallerBundle\Form\DatabaseStep(), $step);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        // test database connection
        $connection = array(
          'driver' => 'pdo_mysql',
          'path' => 'database.'.$step->name
        );
        return $this->redirect($this->generateUrl('club_installer_installer_administrator'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/installer/step/2")
   * @Template()
   */
  public function administratorAction()
  {
    $step = new \Club\InstallerBundle\Step\AdministratorStep();
    $form = $this->createForm(new \Club\InstallerBundle\Form\AdministratorStep(), $step);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        return $this->redirect($this->generateUrl('club_installer_installer_setting'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/installer/step/3")
   * @Template()
   */
  public function settingAction()
  {
    $step = new \Club\InstallerBundle\Step\SettingStep();
    $form = $this->createForm(new \Club\InstallerBundle\Form\SettingStep(), $step);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        return $this->redirect($this->generateUrl('club_installer_installer_confirm'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/installer/step/4")
   * @Template()
   */
  public function confirmAction()
  {
    return array();
  }
}
