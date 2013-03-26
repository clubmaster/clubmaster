<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopController extends Controller
{
  /**
   * @Route("/shop", name="shop")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $location = $em->find('ClubUserBundle:Location', $this->get('session')->get('location_id'));
    if (!$location->getClub()) {
      $locations = $em->getRepository('ClubUserBundle:Location')->findClubs();
      if (count($locations) == 1) {
        $location = $locations[0];
        $this->get('session')->set('location_id', $location->getId());
      } else {
        return $this->redirect($this->generateUrl('club_user_location_index'));
      }
    }

    $categories = $em->getRepository('ClubShopBundle:Category')->getRoot($location);

    if (!count($categories)) {
      $this->get('session')->setFlash('error', $this->get('translator')->trans('There are no categories in this location, choose another location.'));
      $this->get('session')->set('switch_location', $this->generateUrl('shop'));

      return $this->redirect($this->generateUrl('club_user_location_index'));
    }

    $products = $em->getRepository('ClubShopBundle:Product')->findBy(
        array(
            'active' => true
        ),
        array(), 10);

    return array(
      'location' => $location,
      'categories' => $categories,
      'products' => $products
    );
  }

  /**
   * @Route("/shop/category/{id}",name="shop_prod_view")
   * @Template()
   */
  public function categoryAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $categories = $em->getRepository('ClubShopBundle:Category')->findBy(array(
      'category' => $id
    ));
    $category = $em->find('ClubShopBundle:Category',$id);

    return array(
      'location' => $em->find('ClubUserBundle:Location', $this->get('session')->get('location_id')),
      'categories' => $categories,
      'category' => $category
    );
  }

  /**
   * @Route("/shop/category/delete/{id}", name="shop_category_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $category = $em->find('ClubShopBundle:Category',$id);

    $em->remove($category);
    $em->flush();

    return $this->redirect($this->generateUrl('shop_category'));
  }

  /**
   * @Route("/shop/category/edit/{id}", name="shop_category_edit")
   */
  public function editAction($id)
  {
    return array();
  }
}
