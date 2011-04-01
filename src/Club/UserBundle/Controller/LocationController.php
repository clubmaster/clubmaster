<?php

namespace Club\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\UserBundle\Entity\Location;
use Club\UserBundle\Form\LocationForm;

class LocationController extends Controller
{
  /**
   * @extra:Template()
   * @extra:Route("/location", name="location")
   */
  public function indexAction()
  {
    $dql = "SELECT r FROM Club\UserBundle\Entity\Location r ORDER BY r.location_name";
    $em = $this->get('doctrine.orm.entity_manager');

    $query = $em->createQuery($dql);
    $locations = $query->getResult();

    return $this->render('ClubUser:Location:index.html.twig',array(
      'page' => array('header' => 'User'),
      'locations' => $locations
    ));
  }

  /**
   * @extra:Template()
   * @extra:Route("/location/new", name="location_new")
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

    return $this->render('ClubUser:Location:new.html.twig',array(
      'page' => array('header' => 'Location'),
      'form' => $form
    ));
  }

  /**
   * @extra:Template()
   * @extra:Route("/location/edit/{id}", name="location_edit")
   */
  public function editAction($id)
  {
  }

  /**
   * @extra:Route("/location/delete/{id}", name="location_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $location = $em->find('ClubUser:Location',$this->get('request')->get('id'));

    $em->remove($location);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Location %s deleted.',$location->getLocationName()));

    return new RedirectResponse($this->generateUrl('location'));
  }

  /**
   * @extra:Route("/location/batch", name="location_batch")
   */
  public function batchAction()
  {
  }
}
