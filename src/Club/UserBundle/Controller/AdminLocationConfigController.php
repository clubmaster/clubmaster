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

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $this->setData($location, $form->getData());

        return $this->redirect($this->generateUrl('admin_location_config', array(
          'id' => $id
        )));
      }
    }

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

  private function setData(\Club\UserBundle\Entity\Location $location, $data)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $config_repos = $em->getRepository('ClubUserBundle:LocationConfig');

    foreach ($data as $key=>$value) {
      switch ($key) {
      case 'account_default_income':
      case 'account_default_vat':
      case 'account_default_cash':
      case 'account_default_discount':
      case 'default_currency':
      case 'default_language':
      case 'default_location':
        $config = $config_repos->getByKey($key, $location, false);

        if (!$config && $value != '') {
          $config = $config_repos->addConfig($key, $location, $value->getId());
          $em->persist($config);
        } elseif ($value != '') {
          $config->setValue($value->getId());
          $em->persist($config);
        } elseif ($config && $value == '') {
          $em->remove($config);
        }

        break;
      default:
        $config = $em->getRepository('ClubUserBundle:LocationConfig')->getByKey($key, $location, false);

        if (!$config && $value != '') {
          $config = $config_repos->addConfig($key, $location, $value);
          $em->persist($config);
        } elseif ($value != '') {
          $config->setValue($value);
          $em->persist($config);
        } elseif ($config && $value == '') {
          $em->remove($config);
        }
        break;
      }
    }

    $em->flush();
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
      ->add('account_default_cash','entity', array(
        'class' => 'ClubAccountBundle:Account',
        'required' => false
      ))
      ->add('account_default_discount','entity', array(
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
