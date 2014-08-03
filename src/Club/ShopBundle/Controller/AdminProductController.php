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
 * @Route("/admin/shop/product")
 */
class AdminProductController extends Controller
{
    /**
     * @Route("", name="admin_shop_product")
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
     * @Route("/archive", name="admin_shop_product_archive")
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
     * @Route("/new", name="admin_shop_product_new")
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
     * @Route("/edit/{id}", name="admin_shop_product_edit")
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
     * @Route("/activate/{id}", name="admin_shop_product_activate")
     * @Template()
     */
    public function activateAction(Product $product)
    {
        $product->setActive(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_shop_product'));
    }

    /**
     * @Route("/deactivate/{id}", name="admin_shop_product_deactivate")
     * @Template()
     */
    public function deactivateAction(Product $product)
    {
        $product->setActive(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_shop_product'));
    }

    /**
     * @Route("/users/{id}", name="admin_shop_product_users")
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
     * @Route("/image/remove/{id}", name="admin_shop_product_image_remove")
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
     * @Route("/no_category")
     * @Template()
     */
    public function noCategoryAction()
    {
        $this->get('club_extra.flash')->addError($this->get('translator')->trans(
            'You cannot add any products without a category.'
        ));

        return array();
    }
}
