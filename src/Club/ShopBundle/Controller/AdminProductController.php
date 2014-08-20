<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Club\ShopBundle\Entity\Product;
use Club\ShopBundle\Form\ImageType;

/**
 * @Route("/admin")
 */
class AdminProductController extends Controller
{
    /**
     * @Route("/shop/product", name="admin_shop_product")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ClubShopBundle:Category')->findAll();

        if (!count($categories)) {
            return $this->forward('ClubShopBundle:AdminProduct:noCategory');
        }

        $products = $em->getRepository('ClubShopBundle:Product')->getAll();

        return array(
            'products' => $products
        );
    }

    /**
     * @Route("/shop/product/archive", name="admin_shop_product_archive")
     * @Template()
     */
    public function archiveAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ClubShopBundle:Product')->findBy(array(
            'active' => false
        ));

        return array(
            'products' => $products
        );
    }

    /**
     * @Route("/shop/product/new", name="admin_shop_product_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $product = new Product();

        $form = $this->createForm(new \Club\ShopBundle\Form\Product(), $product);
        $form
            ->add('save', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ))
            ;

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);

            if (strlen($product->getImage()->getFileName()) == 0) {
                $em->remove($product->getImage());
                $product->setImage(null);
            }

            $em->flush();

            $this->get('club_extra.flash')->addNotice();

            return $this->redirect($this->generateUrl('admin_shop_product'));
        }


        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/shop/product/edit/{id}", name="admin_shop_product_edit")
     * @Template()
     */
    public function editAction(Request $request, Product $product)
    {
        $form = $this->createForm(new \Club\ShopBundle\Form\Product(), $product);
        $form
            ->add('save', 'submit', array(
                'attr' => array(
                    'class' => 'btn btn-primary'
                )
            ))
            ;

        if ($product->getImage()) {
            $form->remove('image');
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);

            if (strlen($product->getImage()->getFileName()) == 0) {
                $em->remove($product->getImage());
                $product->setImage(null);
            }

            $em->flush();

            $this->get('club_extra.flash')->addNotice();

            return $this->redirect($this->generateUrl('admin_shop_product'));
        }

        return array(
            'product' => $product,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/shop/product/users/{id}", name="admin_shop_product_users")
     * @Template()
     */
    public function usersAction(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('ClubShopBundle:Product')->getUsersByProduct($product);

        return array(
            'product' => $product,
            'users' => $users
        );
    }

    /**
     * @Route("/shop/product/image/remove/{id}", name="admin_shop_product_image_remove")
     * @Template()
     */
    public function imageRemoveAction(Product $product)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($product->getImage());

        $product->setImage(null);
        $em->persist($product);

        $em->flush();

        return $this->redirect($this->generateUrl('admin_shop_product_edit', array(
            'id' => $product->getId()
        )));
    }

    /**
     * @Route("/shop/product/no_category")
     * @Template()
     */
    public function noCategoryAction()
    {
        return array();
    }
}
