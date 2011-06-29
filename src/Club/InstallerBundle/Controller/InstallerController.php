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
      $email = new \Club\UserBundle\Entity\ProfileEmail();
      $email->setContactType('home');
      $email->setIsDefault(1);
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
    if ($this->get('session')->get('installer_location_id')) {
      $location = $em->find('ClubUserBundle:Location',$this->get('session')->get('installer_location_id'));
    } else {
      $location = new \Club\UserBundle\Entity\Location();
    }
    $form = $this->createForm(new \Club\InstallerBundle\Form\LocationStep(), $location);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($location);
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
