<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LocationConfigController extends Controller
{
  /**
   * @Template()
   * @Route("/location/config/{id}", name="admin_location_config")
   */
  public function indexAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $configs = $em->getRepository('\Club\UserBundle\Entity\LocationConfig')->findBy(array(
      'location' => $id
    ));

    return array(
      'configs' => $configs
    );
  }

  /**
   * @Route("/location/config/edit/{id}", name="admin_location_config_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $config = $em->find('Club\UserBundle\Entity\LocationConfig',$id);

    $res = $this->process($config);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'config' => $config,
      'form' => $res->createView()
    );
  }

  protected function process($config)
  {
    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\LocationConfig(), $config);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($config);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_location_config',array('id'=>$config->getLocation()->getId())));
      }
    }

    return $form;
  }
}
