<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/user/import")
 */
class AdminUserImportController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $form = $this->getForm();

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/import")
   */
  public function importAction()
  {
    $form = $this->getForm();
    $form->bindRequest($this->getRequest());
    if ($form->isValid()) {
      $r = $form->getData();

      $delimiter = null;
      switch ($r['field_delimiter']) {
      case 'tab':
        $delimiter = "\t";
        break;
      case 'comma':
        $delimiter = ',';
        break;
      }

      $first_line = true;
      if (($handle = fopen($r['user_file']->getPathName(), "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {

          if ($first_line && $r['skip_first_line']) {
            $first_line = false;
          } else {
            $this->addUser($data);
          }
        }
        fclose($handle);
      }
    }

    $em = $this->getDoctrine()->getEntityManager();

    return $this->redirect($this->generateUrl('club_user_adminuserimport_index'));
  }

  private function addUser(array $data)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $this->get('clubmaster.user')->buildUser();
    $user = $this->get('clubmaster.user')->get();

    if (strlen($data[0])) {
      $user->setMemberNumber($data[0]);
    } else {
      $number = $em->getRepository('ClubUserBundle:User')->findNextMemberNumber();
      $user->setMemberNumber($number);
    }

    if (strlen($data[1])) {
      $user->setPassword($data[1]);
    } else {
      $user->setPassword('password');
      $reset = new \Club\UserBundle\Entity\ResetPassword();
      $reset->setUser($user);
      $em->persist($reset);
    }

    $profile = $user->getProfile();
    $profile->setFirstName($data[2]);
    $profile->setLastName($data[3]);

    $gender = ($data[4] == 'female') ? 'female' : 'male';
    $profile->setGender($gender);
    $profile->setDayOfBirth(new \DateTime($data[5]));

    $p_address = $profile->getProfileAddress();
    $p_address->setStreet($data[6]);
    $p_address->setPostalCode($data[7]);
    $p_address->setCity($data[8]);
    $p_address->setCountry($data[9]);

    if (!isset($data[10]) || !strlen($data[10])) {
      $profile->setProfilePhone(null);
    } else {
      $p_phone = $profile->getProfilePhone();
      $p_phone->setPhoneNumber($data[10]);
    }

    if (!isset($data[11]) || !strlen($data[11])) {
      $profile->setProfileEmail(null);
    } else {
      $p_email = $profile->getProfileEmail();
      $p_email->setEmailAddress($data[11]);
    }

    $em->persist($user);
    $em->flush();

    return $user;
  }

  private function getForm()
  {
    $boolean = array(
      0 => 'No',
      1 => 'Yes'
    );

    return $this->createFormBuilder()
      ->add('user_file', 'file')
      ->add('skip_first_line', 'choice', array(
        'choices' => $boolean
      ))
      ->add('field_delimiter', 'choice', array(
        'choices' => array(
          'tab' => 'TAB',
          'comma' => 'comma'
        ),
        'required' => false
      ))
      ->getForm();
  }
}
