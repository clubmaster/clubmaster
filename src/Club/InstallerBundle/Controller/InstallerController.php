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
   * @Route("/installer/database")
   * @Template()
   */
  public function databaseAction()
  {
    return array();
  }

  /**
   * @Route("/installer/administrator")
   * @Template()
   */
  public function administratorAction()
  {
    return array();
  }

  /**
   * @Route("/installer/settings")
   * @Template()
   */
  public function settingsAction()
  {
    return array();
  }

  /**
   * @Route("/installer/confirm")
   * @Template()
   */
  public function confirmAction()
  {
    return array();
  }
}
