<?php

namespace Club\InstallerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InstallerController extends Controller
{
  public function __construct()
  {
    $file = __DIR__.'/../../../../installer';
    if (!file_exists($file))
      die('The installer is not available.');
  }

  /**
   * @Route("/installer")
   * @Template()
   */
  public function indexAction()
  {
    $this->get('session')->set('installer_user_id',null);
    $this->get('session')->set('installer_location_id',null);

    return array();
  }

  /**
   * @Route("/installer/step/1")
   * @Template()
   */
  public function administratorAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    if ($this->get('session')->get('installer_user_id')) {
      $user = $em->find('ClubUserBundle:User',$this->get('session')->get('installer_user_id'));
    } else {
      $user = new \Club\UserBundle\Entity\User();
      $user->setMemberNumber($em->getRepository('ClubUserBundle:User')->findNextMemberNumber());
      $profile = new \Club\UserBundle\Entity\Profile();
      $user->setProfile($profile);
      $profile->setUser($user);
      $email = new \Club\UserBundle\Entity\ProfileEmail();
      $email->setContactType('home');
      $email->setIsDefault(1);
      $email->setProfile($profile);
      $profile->addProfileEmail($email);
    }

    $form = $this->createForm(new \Club\InstallerBundle\Form\AdministratorStep(), $user);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $group = $em->getRepository('ClubUserBundle:Group')->findOneBy(array(
          'group_name' => 'Super Administrators'
        ));

        $group->addUsers($user);

        $em->persist($user);
        $em->flush();

        $this->get('session')->set('installer_user_id',$user->getId());
        return $this->redirect($this->generateUrl('club_installer_installer_location'));
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
  public function locationAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $location_step = new \Club\InstallerBundle\Step\LocationStep();
    $form = $this->createForm(new \Club\InstallerBundle\Form\LocationStep(), $location_step);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $location = new \Club\UserBundle\Entity\Location();
        $location->setLocation($em->find('ClubUserBundle:Location',1));
        $location->setLocationName($location_step->location_name);
        $em->persist($location);

        $location_config = $em->getRepository('ClubUserBundle:LocationConfig')->findOneBy(array(
          'location' => 1,
          'config' => 'default_currency'
        ));
        $location_config->setValue($location_step->currency->getId());
        $em->persist($location_config);

        $em->flush();

        $this->get('session')->set('installer_location_id',$location->getId());
        return $this->redirect($this->generateUrl('club_installer_installer_confirm'));
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
  public function confirmAction()
  {
    return array();
  }
}
