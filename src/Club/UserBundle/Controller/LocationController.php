<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LocationController extends Controller
{
  /**
   * @Template()
   * @Route("/location", name="admin_location")
   */
  public function indexAction()
  {
    $dql = "SELECT r FROM Club\UserBundle\Entity\Location r ORDER BY r.location_name";
    $em = $this->get('doctrine.orm.entity_manager');

    $query = $em->createQuery($dql);
    $locations = $query->getResult();

    return $this->render('ClubUserBundle:Location:index.html.twig',array(
      'page' => array('header' => 'User'),
      'locations' => $locations
    ));
  }

  /**
   * @Template()
   * @Route("/location/new", name="admin_location_new")
   */
  public function newAction()
  {
    $location = new \Club\UserBundle\Entity\Location();
    $res = $this->process($location);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'page' => array('header' => 'Location'),
      'form' => $res->createView()
    );
  }

  /**
   * @Template()
   * @Route("/location/edit/{id}", name="admin_location_edit")
   */
  public function editAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $location = $em->find('Club\UserBundle\Entity\Location',$id);

    $res = $this->process($location);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'location' => $location,
      'page' => array('header' => 'Location'),
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/location/delete/{id}", name="admin_location_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $location = $em->find('ClubUserBundle:Location',$this->get('request')->get('id'));

    $em->remove($location);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Location %s deleted.',$location->getLocationName()));

    return new RedirectResponse($this->generateUrl('admin_location'));
  }

  /**
   * @Route("/location/batch", name="admin_location_batch")
   */
  public function batchAction()
  {
  }

  protected function process($location)
  {
    $form = $this->get('form.factory')->create(new \Club\UserBundle\Form\Location(), $location);

    if ($this->get('request')->getMethod() == 'POST') {
      $form->bindRequest($this->get('request'));
      if ($form->isValid()) {
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($location);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_location'));
      }
    }

    return $form;
  }
}
