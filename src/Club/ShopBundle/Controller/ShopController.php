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

        $location = $this->get('club_user.location')->getCurrent();

        if (!$location->getClub()) {
            $locations = $em->getRepository('ClubUserBundle:Location')->findClubs();
            if (count($locations) == 1) {
                $location = $locations[0];
                $this->get('club_user.location')->setCurrent($location);
            } else {
                return $this->redirect($this->generateUrl('club_user_location_index'));
            }
        }

        $categories = $em->getRepository('ClubShopBundle:Category')->getRoot($location);

        if (!count($categories)) {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('There are no categories in this location, choose another location.'));
            $this->get('session')->set('switch_location', $this->generateUrl('shop'));

            return $this->redirect($this->generateUrl('club_user_location_index'));
        }

        $products = $em->getRepository('ClubShopBundle:Product')->getActive();

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
    public function categoryAction(\Club\ShopBundle\Entity\Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ClubShopBundle:Category')->findBy(array(
            'category' => $category->getId()
        ));

        $products = $em->getRepository('ClubShopBundle:Product')->getByCategory($category);

        return array(
            'location' => $this->get('club_user.location')->getCurrent(),
            'categories' => $categories,
            'category' => $category,
            'products' => $products
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
