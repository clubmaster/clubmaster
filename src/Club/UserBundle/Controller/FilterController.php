<?php

namespace Club\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    return new RedirectResponse($this->generateUrl('admin_user'));
  }

  public function getFilterFormAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = $em->getRepository('ClubUserBundle:Filter')->findOneBy(array(
      'user' => $this->get('security.context')->getToken()->getUser()->getId(),
      'is_active' => 1
    ));

    if (!$filter) {
      $filter = $this->initFilter();
    }

    $form = $this->createFormBuilder($filter)
      ->add('attributes', 'collection', array(
        'type' => new \Club\UserBundle\Form\FilterAttribute()
      ))
      ->getForm();

    return $this->render('ClubUserBundle:Filter:form.html.twig', array(
      'form' => $form->createView()
    ));
  }

  protected function initFilter()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = new \Club\UserBundle\Entity\Filter;
    $filter->setFilterName('Working');
    $filter->setIsActive(1);
    $filter->setUser($this->get('security.context')->getToken()->getUser());

    $attributes = $em->getRepository('ClubUserBundle:Attribute')->findAll();

    foreach ($attributes as $attr) {
      $filter_attr = new \Club\UserBundle\Entity\FilterAttribute();
      $filter_attr->setFilter($filter);
      $filter_attr->setAttribute($attr);
      $filter->addAttributes($filter_attr);
    }

    return $filter;
  }
}
