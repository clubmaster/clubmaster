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

    $form_filter = new \Club\UserBundle\Filter\UserFilter();
    $form = $this->createForm(new \Club\UserBundle\Form\Filter(), $form_filter);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $data = $form->getData();

        $filter = $this->getActiveFilter();
        $filter = $this->syncFilters($filter,$data);
      }
    }

    return $this->redirect($this->generateUrl('admin_user'));
  }

  public function getFilterAction()
  {
    $form_filter = $this->buildFormFilter();
    $form = $this->createForm(new \Club\UserBundle\Form\Filter(), $form_filter);

    return $this->render('ClubUserBundle:Filter:form.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * Syncronize form filter with database object
   */
  private function syncFilters($filter,$data)
  {
    $min_age = ($data->min_age != '') ? $data->min_age : null;
    $max_age = ($data->max_age != '') ? $data->max_age : null;
    $gender = ($data->gender != '') ? $data->gender : null;
    $postal_code = ($data->postal_code != '') ? $data->postal_code : null;
    $city = ($data->city != '') ? $data->city : null;
    $country = ($data->country != '') ? $data->country->getId() : null;
    $is_active = ($data->is_active != '') ? $data->is_active : null;
    $has_ticket= ($data->has_ticket != '') ? $data->has_ticket : null;
    $has_subscription = ($data->has_subscription != '') ? $data->has_subscription : null;

    $this->syncColumn($filter, 'min_age', $min_age);
    $this->syncColumn($filter, 'max_age', $max_age);
    $this->syncColumn($filter, 'gender', $gender);
    $this->syncColumn($filter, 'postal_code', $postal_code);
    $this->syncColumn($filter, 'city', $data->city);
    $this->syncColumn($filter, 'country', $country);
    $this->syncColumn($filter, 'is_active', $is_active);
    $this->syncColumn($filter, 'has_ticket', $has_ticket);
    $this->syncColumn($filter, 'has_subscription', $has_subscription);

    $str = '';
    foreach ($data->location as $l) {
      $str .= $l->getId().',';
    }
    $str = preg_replace("/,$/","",$str);
    $str = ($str != '') ? $str : null;
    $this->syncColumn($filter, 'location', $str);

    $em = $this->getDoctrine()->getEntityManager();
    $em->flush();
  }

  /**
   * Syncronize a data column
   */
  private function syncColumn($filter, $column, $value)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $attr = $em->getRepository('ClubUserBundle:Attribute')->findOneBy(array(
      'attribute_name' => $column
    ));

    $filter_attr = $em->getRepository('ClubUserBundle:FilterAttribute')->findOneBy(array(
      'filter' => $filter->getId(),
      'attribute' => $attr->getId()
    ));
    $filter_attr->setValue($value);

    $em->persist($filter_attr);
  }

  /**
   * Get the users active filter object
   * If none exists initialize a new one
   */
  private function getActiveFilter()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = $em->getRepository('ClubUserBundle:Filter')->findActive(
      $this->get('security.context')->getToken()->getUser()
    );

    return $filter;
  }

  /**
   * Build the form filter
   */
  private function buildFormFilter()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = $em->getRepository('ClubUserBundle:Filter')->findActive(
      $this->get('security.context')->getToken()->getUser()
    );
    $form_filter = new \Club\UserBundle\Filter\UserFilter();

    foreach ($filter->getAttributes() as $attribute) {
      switch ($attribute->getAttribute()->getAttributeName()) {
      case 'min_age':
        $form_filter->min_age = $attribute->getValue();
        break;
      case 'max_age':
        $form_filter->max_age = $attribute->getValue();
        break;
      case 'gender':
        $form_filter->gender = $attribute->getValue();
        break;
      case 'postal_code':
        $form_filter->postal_code = $attribute->getValue();
        break;
      case 'city':
        $form_filter->city = $attribute->getValue();
        break;
      case 'country':
        $form_filter->country = $em->find('ClubUserBundle:Country',$attribute->getValue());
        break;
      case 'is_active':
        $form_filter->is_active = $attribute->getValue();
        break;
      case 'has_ticket':
        $form_filter->has_ticket = $attribute->getValue();
        break;
      case 'has_subscription':
        $form_filter->has_subscription = $attribute->getValue();
        break;
      case 'location':
        $res = new \Doctrine\Common\Collections\ArrayCollection();
        $locations = $em->getRepository('ClubUserBundle:Location')->getByIds(explode(",", $attribute->getValue()));

        foreach ($locations as $location) {
          $res[] = $location;
        }

        $form_filter->location = $res;
        break;
      }
    }

    return $form_filter;
  }
}
