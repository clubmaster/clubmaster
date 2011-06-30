<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    $configs = $em->getRepository('ClubUserBundle:LocationConfig')->findBy(array(
      'location' => $location->getId()
    ));

    return array(
      'location' => $location,
      'configs' => $configs
    );
  }

  /**
   * @Route("/location/config/new/{id}")
   * @Template()
   */
  public function newAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $location = $em->find('ClubUserBundle:Location',$id);
    $config = new \Club\UserBundle\Entity\LocationConfig($location);
    $config->setLocation($location);

    $res = $this->process($config);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'location' => $location,
      'config' => $config,
      'form' => $res->createView(),
      'configs' => $em->getRepository('ClubUserBundle:Config')->findAll()
    );
  }

  /**
   * @Route("/location/config/edit/{id}", name="admin_location_config_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $config = $em->find('ClubUserBundle:LocationConfig',$id);

    $res = $this->process($config);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'config' => $config,
      'form' => $res->createView(),
      'configs' => $em->getRepository('ClubUserBundle:Config')->findAll()
    );
  }

  /**
   * @Route("/location/config/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $config = $em->find('ClubUserBundle:LocationConfig',$id);
    $em->remove($config);

    $em->flush();

    return $this->redirect($this->generateUrl('admin_location_config',array(
      'id' => $config->getLocation()->getId()
    )));
  }
  protected function process($config)
  {
    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\LocationConfig(), $config);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($config);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return $this->redirect($this->generateUrl('admin_location_config',array('id'=>$config->getLocation()->getId())));
      }
    }

    return $form;
  }
}
