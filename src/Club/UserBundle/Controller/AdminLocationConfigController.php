<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminLocationConfigController extends Controller
{
  /**
   * @Template()
   * @Route("/location/config/{id}", name="admin_location_config")
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $location = $em->find('ClubUserBundle:Location',$id);

    $form = $this->getForm();
    $form->setData($this->getData($location));

    return array(
      'location' => $location,
      'form' => $form->createView()
    );
  }

  private function getData(\Club\UserBundle\Entity\Location $location)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $configs = $em->getRepository('ClubUserBundle:Config')->findAll();

    $arr = array();

    foreach ($configs as $config) {
      $arr[$config->getConfigKey()] = $em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey($config->getConfigKey(), $location, false);
    }

    return $arr;
  }

  private function getForm()
  {
    $form = $this->createFormBuilder()
      ->add('account_default_income','entity', array(
        'class' => 'ClubAccountBundle:Account',
        'required' => false
      ))
      ->add('account_default_vat','entity', array(
        'class' => 'ClubAccountBundle:Account',
        'required' => false
      ))
      ->add('default_currency','entity', array(
        'class' => 'ClubUserBundle:Currency',
        'required' => false
      ))
      ->add('default_language','entity', array(
        'class' => 'ClubUserBundle:Language',
        'required' => false
      ))
      ->add('default_location','entity', array(
        'class' => 'ClubUserBundle:Location',
        'required' => false
      ))

      ->add('email_sender_address','text', array(
        'required' => false
      ))
      ->add('email_sender_name','text', array(
        'required' => false
      ))
      ->getForm();

    return $form;
  }
}
