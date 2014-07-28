<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin")
 */
class AdminProductAttributeController extends Controller
{
    /**
     * @Route("/shop/product/attribute/{id}", name="admin_shop_product_attribute")
     * @Template()
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->find('ClubShopBundle:Product',$id);
        $form = $this->getForm($product);

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $this->setData($product,$form->getData());

                $this->get('club_user.flash')->addNotice();

                return $this->redirect($this->generateUrl('admin_shop_product_attribute',array(
                    'id' => $id
                )));
            } else {
                foreach ($form->getErrors() as $error) {
                    $this->get('session')->getFlashBag()->add('error', $error->getMessage());
                }
            }
        } else {
            $form->setData($this->getData($product));
        }

        return array(
            'form' => $form->createView(),
            'product' => $product
        );
    }

    private function getForm($product)
    {
        $form = $this->createForm(new \Club\ShopBundle\Form\ProductAttribute());

        return $form;
    }

    private function getData($product)
    {
        $em = $this->getDoctrine()->getManager();
        $attribute = $this->get('club_shop.product')->getAttribute($product);

        return $attribute;
    }

    private function setData(\Club\ShopBundle\Entity\Product $product, $data)
    {
        $em = $this->getDoctrine()->getManager();

        foreach ($data as $attribute => $value) {

            if ($attribute == 'location') {
                $str = '';
                foreach ($value as $l) {
                    $str .= $l->getId().',';
                }
                $str = preg_replace("/,$/","",$str);
                $value = ($str != '') ? $str : null;
            }

            if (preg_match("/^(start_date|expire_date)$/", $attribute) && $value != '')
                $value = $value->format('Y-m-d');
            if (preg_match("/^(start_time|stop_time)$/", $attribute) && $value != '')
                $value = $value->format('H:i:s');

            $prod_attr = $em->getRepository('ClubShopBundle:ProductAttribute')->findOneBy(array(
                'product' => $product->getId(),
                'attribute' => $attribute
            ));

            if (strlen($value)) {
                $prod_attr = (!$prod_attr) ? $this->buildProductAttribute($product, $attribute) : $prod_attr;

                $prod_attr->setValue($value);
                $em->persist($prod_attr);

            } elseif ($prod_attr && $value == '') {
                $em->remove($prod_attr);
            }
        }

        $em->flush();
    }

    private function buildProductAttribute(\Club\ShopBundle\Entity\Product $product, $attribute)
    {
        $prod_attr = new \Club\ShopBundle\Entity\ProductAttribute();
        $prod_attr->setProduct($product);
        $prod_attr->setAttribute($attribute);

        return $prod_attr;
    }
}
