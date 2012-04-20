<?php

namespace Club\InstallerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InstallerController extends Controller
{
  public function __construct()
  {
    $file = __DIR__.'/../../../../app/installer';
    if (!file_exists($file))
      die('The installer is not available.');
  }

  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
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
    return array();
  }

  /**
   * @Route("/step/2")
   * @Template()
   */
  public function administratorAction()
  {
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
      $form->bindRequest($this->getRequest());

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
    $em = $this->getDoctrine()->getEntityManager();

    $location_step = new \Club\InstallerBundle\Step\LocationStep();
    $form = $this->createForm(new \Club\InstallerBundle\Form\LocationStep(), $location_step);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

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
    return array();
  }

  /**
   * @Route("/migrate")
   * @Template()
   */
  public function migrateAction()
  {
    $this->get('club_installer.database')->migrate();

    $this->get('session')->setFlash('notice', 'Database was successful installed');
    return $this->redirect($this->generateUrl('club_installer_installer_administrator'));
  }
}
