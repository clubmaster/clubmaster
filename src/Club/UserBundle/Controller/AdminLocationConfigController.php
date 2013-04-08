<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/{_locale}/admin")
 */
class AdminLocationConfigController extends Controller
{
  /**
   * @Template()
   * @Route("/location/config/{id}", name="admin_location_config")
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $location = $em->find('ClubUserBundle:Location',$id);

    $form = $this->getForm();
    $form->setData($this->getData($location));

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $this->setData($location, $form->getData());
        $this->get('session')->getFlashBag()->add('notice', $this->get('translator')->trans('Your changes are saved.'));

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
    $em = $this->getDoctrine()->getManager();
    $configs = array(
      'default_currency',
      'email_sender_address',
      'email_sender_name'
    );

    $arr = array();

    foreach ($configs as $config) {
      $arr[$config] = $em->getRepository('ClubUserBundle:LocationConfig')->getObjectByKey($config, $location, false);
    }

    return $arr;
  }

  private function setData(\Club\UserBundle\Entity\Location $location, $data)
  {
    $em = $this->getDoctrine()->getManager();
    $config_repos = $em->getRepository('ClubUserBundle:LocationConfig');

    foreach ($data as $key=>$value) {
      switch ($key) {
      case 'default_currency':
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
      ->add('default_currency','entity', array(
        'class' => 'ClubUserBundle:Currency',
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
