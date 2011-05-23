<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\Location;
use Club\UserBundle\Form\LocationForm;

class LocationController extends Controller
{
  /**
   * @Template()
   * @Route("/location", name="location")
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
   * @Route("/location/new", name="location_new")
   */
  public function newAction()
  {
    $location = new Location();
    $form = LocationForm::create($this->get('form.context'),'location');

    $form->bind($this->get('request'),$location);
    if ($form->isValid()) {
      $em = $this->get('doctrine.orm.entity_manager');
      $em->persist($location);
      $em->flush();

      $this->get('session')->setFlash('notice','Your changes were saved!');

      return new RedirectResponse($this->generateUrl('location'));
    }

    return array(
      'page' => array('header' => 'Location'),
      'form' => $form
    );
  }

  /**
   * @Template()
   * @Route("/location/edit/{id}", name="location_edit")
   */
  public function editAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $location = $em->find('Club\UserBundle\Entity\Location',$id);

    $form = LocationForm::create($this->get('form.context'),'location');

    $form->bind($this->get('request'),$location);
    if ($form->isValid()) {
      $em->persist($location);
      $em->flush();

      $this->get('session')->setFlash('notice','Your changes were saved!');

      return new RedirectResponse($this->generateUrl('location'));
    }

    return array(
      'location' => $location,
      'page' => array('header' => 'Location'),
      'form' => $form
    );
  }

  /**
   * @Route("/location/delete/{id}", name="location_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $location = $em->find('ClubUserBundle:Location',$this->get('request')->get('id'));

    $em->remove($location);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Location %s deleted.',$location->getLocationName()));

    return new RedirectResponse($this->generateUrl('location'));
  }

  /**
   * @Route("/location/batch", name="location_batch")
   */
  public function batchAction()
  {
  }
}
