<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/shop/product/{id}", name="shop_product")
     * @Template()
     */
    public function indexAction(\Club\ShopBundle\Entity\Product $product)
    {
        $attr = $this->get('club_shop.product')->getAttribute($product);

        return array(
            'product' => $product,
            'attr' => $attr
        );
    }

    /**
     * @Route("/shop/product/cart/{id}", name="shop_product_cart")
     * @Template()
     */
    public function cartAction(\Club\ShopBundle\Entity\Product $product)
    {
        try {
            $this->get('cart')
                ->getCurrent()
                ->addToCart($product);

        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->add('error',$e->getMessage());
        }

        return $this->redirect($this->generateUrl('shop_checkout'));
    }
}
