<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopController extends Controller
{
    /**
     * @Route("/shop", name="shop", defaults={"page" = 1})
     * @Route("/shop/{page}", name="shop_offset")
     * @Template()
     */
    public function indexAction($page)
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

        $res = array();
        foreach ($categories as $cat) {
            if (count($cat->getActiveProducts())) {
                $res[] = $cat;
            }
        }
        $categories = $res;

        if (!count($categories)) {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('There are no categories in this location, choose another location.'));
            $this->get('session')->set('switch_location', $this->generateUrl('shop'));

            return $this->redirect($this->generateUrl('club_user_location_index'));
        }

        $results = 10;
        $paginator = $em->getRepository('ClubShopBundle:Product')->getPaginator($results, $page);

        $this->get('club_extra.paginator')
            ->init($results, count($paginator), $page, 'shop_offset');

        return array(
            'location' => $location,
            'categories' => $categories,
            'paginator' => $paginator
        );
    }

    /**
     * @Route("/shop/category/{id}",name="shop_prod_view", defaults={"page" = 1})
     * @Route("/shop/category/{id}/{page}", name="shop_prod_view_offset")
     * @Template()
     */
    public function categoryAction(\Club\ShopBundle\Entity\Category $category, $page)
    {
        $results = 20;

        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ClubShopBundle:Category')->findBy(array(
            'category' => $category->getId()
        ));

        $paginator = $em->getRepository('ClubShopBundle:Product')->getByCategory($category, $results, $page);

        $this->get('club_extra.paginator')
            ->init($results, count($paginator), $page, 'shop_prod_view_offset', array('id' => $category->getId()));

        return array(
            'location' => $this->get('club_user.location')->getCurrent(),
            'categories' => $categories,
            'category' => $category,
            'paginator' => $paginator
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
