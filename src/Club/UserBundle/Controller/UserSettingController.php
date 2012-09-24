<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/{_locale}/user/setting")
 */
class UserSettingController extends Controller
{
  /**
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $settings = $em->getRepository('ClubUserBundle:UserSetting')->getUserArray($this->getUser());
    $form = $this->getForm($settings);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $this->sync($form->getData());

        $em->flush();
        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
        $this->get('clubmaster.user')->updateUserSettings();

        return $this->redirect($this->generateUrl('club_user_usersetting_index'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  protected function sync(array $data)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $this->getUser();

    foreach ($data as $key=>$value) {
      $attr = $em->getRepository('ClubUserBundle:UserSetting')->findOneBy(array(
        'user' => $user->getId(),
        'attribute' => $key
      ));

      if ($attr && !strlen($value)) {
        $em->remove($attr);
      } elseif (!$attr && strlen($value)) {
        $attr = new \Club\UserBundle\Entity\UserSetting();
        $attr->setUser($user);
        $attr->setAttribute($key);

        $attr->setValue($value);
        $em->persist($attr);
      } elseif (strlen($value)) {
        $attr->setValue($value);
        $em->persist($attr);
      }
    }
  }

  protected function getForm(array $settings)
  {
    $boolean = array(
      0 => 'No',
      1 => 'Yes'
    );
    $languages = array(
      'da' => 'Danish',
      'en' => 'English'
    );

    $form  = $this->createFormBuilder($settings)
      ->add('receive_email_on_booking', 'choice', array(
        'choices' => $boolean,
        'required' => false,
      ))
      ->add('public_booking_activity', 'choice', array(
        'choices' => $boolean,
        'required' => false
      ))
      ->add('language', 'language', array(
        'choices' => $languages,
        'required' => false
      ))
      ->add('dateformat', 'language', array(
        'required' => false
      ))
      ->add('timezone', 'timezone', array(
        'required' => false
      ))
      ->getForm();

    return $form;
  }
}
