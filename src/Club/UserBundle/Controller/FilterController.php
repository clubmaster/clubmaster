<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FilterController extends Controller
{
  /**
   * @Route("/filter/filter")
   */
  public function filterAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = $em->getRepository('ClubUserBundle:Filter')->findActive($this->get('security.context')->getToken()->getUser());

    if (!$filter) {
      $filter = $this->initFilter();
    }

    $form = $this->createFormBuilder($filter)
      ->add('attributes', 'collection', array(
        'type' => new \Club\UserBundle\Form\FilterAttribute()
      ))
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      $em->persist($filter);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('admin_user'));
  }

  public function getFilterFormAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = $em->getRepository('ClubUserBundle:Filter')->findActive($this->get('security.context')->getToken()->getUser());

    $form = $this->createFormBuilder($filter)
      ->add('attributes', 'collection', array(
        'type' => new \Club\UserBundle\Form\FilterAttribute()
      ))
      ->getForm();

    return $this->render('ClubUserBundle:Filter:form.html.twig', array(
      'form' => $form->createView()
    ));
  }
}
