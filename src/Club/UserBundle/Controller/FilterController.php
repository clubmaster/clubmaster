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

    $filter = $em->getRepository('ClubUserBundle:Filter')->findActive(
      $this->get('security.context')->getToken()->getUser()
    );

    $form_filter = new \Club\UserBundle\Filter\UserFilter($filter);
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

  /**
   * @Route("/filter/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = $em->find('ClubUserBundle:Filter',$id);

    $em->remove($filter);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_user'));
  }

  /**
   * @Route("/filter/new")
   */
  public function newAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = $em->getRepository('ClubUserBundle:Filter')->createFilter(
      $this->get('security.context')->getToken()->getUser()
    );

    $em->getRepository('ClubUserBundle:Filter')->activateFilter(
      $this->get('security.context')->getToken()->getUser(),
      $filter
    );

    $em->persist($filter);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_user'));
  }

  /**
   * @Route("/filter/save/{id}")
   * @Template()
   */
  public function saveAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $filter = $em->find('ClubUserBundle:Filter',$id);

    $form = $this->createFormBuilder($filter)
      ->add('filter_name')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($filter);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_user'));
      }
    }

    return array(
      'filter' => $filter,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/filter/change")
   */
  public function changeAction()
  {
    $form = $this->buildFormFilters();
    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $data = $form->getData();

        $em = $this->getDoctrine()->getEntityManager();
        $em->getRepository('ClubUserBundle:Filter')->activateFilter(
          $this->get('security.context')->getToken()->getUser(),
          $data['filter']
        );
        $em->flush();

      }
    }

    return $this->redirect($this->generateUrl('admin_user'));
  }

  public function getFilterAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repos = $em->getRepository('ClubUserBundle:Filter');

    $filters = $repos->findBy(array(
      'user' => $this->get('security.context')->getToken()->getUser()
    ));
    $filter = $repos->findActive(
      $this->get('security.context')->getToken()->getUser()
    );

    $form_filters = $this->buildFormFilters($filter);
    $form_filter = $this->buildFormFilter($filter);
    $form = $this->createForm(new \Club\UserBundle\Form\Filter(), $form_filter);

    return $this->render('ClubUserBundle:Filter:form.html.twig', array(
      'filter' => $filter,
      'form' => $form->createView(),
      'form_filters' => $form_filters->createView()
    ));
  }

  /**
   * Syncronize form filter with database object
   */
  private function syncFilters($filter,$data)
  {
    $name = ($data->name != '') ? $data->name : null;
    $member_number = ($data->member_number != '') ? $data->member_number : null;
    $min_age = ($data->min_age != '') ? $data->min_age : null;
    $max_age = ($data->max_age != '') ? $data->max_age : null;
    $gender = ($data->gender != '') ? $data->gender : null;
    $postal_code = ($data->postal_code != '') ? $data->postal_code : null;
    $city = ($data->city != '') ? $data->city : null;
    $country = ($data->country != '') ? $data->country->getId() : null;
    $active = ($data->active != '') ? $data->active : null;
    $has_ticket= ($data->has_ticket != '') ? $data->has_ticket : null;
    $has_subscription = ($data->has_subscription != '') ? $data->has_subscription : null;

    $this->syncColumn($filter, 'name', $name);
    $this->syncColumn($filter, 'member_number', $member_number);
    $this->syncColumn($filter, 'min_age', $min_age);
    $this->syncColumn($filter, 'max_age', $max_age);
    $this->syncColumn($filter, 'gender', $gender);
    $this->syncColumn($filter, 'postal_code', $postal_code);
    $this->syncColumn($filter, 'city', $data->city);
    $this->syncColumn($filter, 'country', $country);
    $this->syncColumn($filter, 'active', $active);
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

  private function buildFormFilters(\Club\UserBundle\Entity\Filter $filter = null)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $repos = $em->getRepository('ClubUserBundle:Filter');

    $filters = $repos->findBy(array(
      'user' => $this->get('security.context')->getToken()->getUser()
    ));

    $qb = $em->createQueryBuilder()
      ->select('f')
      ->from('ClubUserBundle:Filter','f')
      ->where('f.user = :user')
      ->setParameter('user',$this->get('security.context')->getToken()->getUser()->getId())
      ->orderBy('f.filter_name');

    $arr = array();

    if ($filter)
      $arr['filter'] = $filter;

    return $this->createFormBuilder($arr)
      ->add('filter','entity',array(
        'class' => 'ClubUserBundle:Filter',
        'query_builder' => $qb
      ))
      ->getForm();
  }

  /**
   * Build the form filter
   */
  private function buildFormFilter(\Club\UserBundle\Entity\Filter $filter)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $form_filter = new \Club\UserBundle\Filter\UserFilter();

    foreach ($filter->getAttributes() as $attribute) {
      switch ($attribute->getAttribute()->getAttributeName()) {
      case 'name':
        $form_filter->name = $attribute->getValue();
        break;
      case 'member_number':
        $form_filter->member_number = $attribute->getValue();
        break;
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
      case 'active':
        $form_filter->active = $attribute->getValue();
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
