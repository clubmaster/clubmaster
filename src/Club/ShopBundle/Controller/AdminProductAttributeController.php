<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminProductAttributeController extends Controller
{
  /**
   * @Route("/shop/product/attribute/{id}", name="admin_shop_product_attribute")
   * @Template()
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $product = $em->find('ClubShopBundle:Product',$id);

    $form = $this->getForm($product);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $this->setData($product,$form->getData());

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('admin_shop_product_attribute',array(
          'id' => $id
        )));
      }
    }
    return array(
      'form' => $form->createView(),
      'product' => $product
    );
  }

  private function getForm($product)
  {
    $form = $this->createForm(new \Club\ShopBundle\Form\ProductAttribute(), $this->getData($product));

    return $form;
  }

  private function getData($product)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $attribute = new \Club\ShopBundle\Model\Attribute();

    foreach ($product->getProductAttributes() as $attr) {
      $val = $attr->getAttribute()->getAttributeName();
      if ($attr->getAttribute()->getAttributeName() == 'location') {
        $res = new \Doctrine\Common\Collections\ArrayCollection();
        $locations = $em->getRepository('ClubUserBundle:Location')->getByIds(explode(",", $attr->getValue()));
        foreach ($locations as $location) {
          $res[] = $location;
        }
        $attribute->$val = $res;

      } elseif ($attr->getAttribute()->getAttributeName() == 'start_date' || $attr->getAttribute()->getAttributeName() == 'expire_date') {
        $attribute->$val = new \DateTime($attr->getValue());
      } else {
        $attribute->$val = $attr->getValue();
      }
    }

    return $attribute;
  }

  private function setData(\Club\ShopBundle\Entity\Product $product, $data)
  {
    $em = $this->getDoctrine()->getEntityManager();

    foreach ($em->getRepository('ClubShopBundle:Attribute')->findAll() as $attr) {
      $val = $attr->getAttributeName();

      $prod_attr = $em->getRepository('ClubShopBundle:ProductAttribute')->findOneBy(array(
        'product' => $product->getId(),
        'attribute' => $attr->getId()
      ));

      if (($attr->getAttributeName() == 'start_date' || $attr->getAttributeName() == 'expire_date') && $data->$val != '')
        $data->$val = $data->$val->format('Y-m-d');

      if ($attr->getAttributeName() == 'location') {
        $str = '';
        foreach ($data->$val as $l) {
          $str .= $l->getId().',';
        }
        $str = preg_replace("/,$/","",$str);
        $str = ($str != '') ? $str : null;

        if ($str == '') {
          if ($prod_attr)
            $em->remove($prod_attr);
        } else {
          if (!$prod_attr)
            $prod_attr = $this->buildProductAttribute($product,$attr);

          $prod_attr->setValue($str);
          $em->persist($prod_attr);
        }

      } else {

        if ($prod_attr && $data->$val == '') {
          $em->remove($prod_attr);

        } elseif ($prod_attr && $data->$val != '') {
          $prod_attr->setValue($data->$val);
          $em->persist($prod_attr);

        } elseif (!$prod_attr && $data->$val != '') {
          $prod_attr = $this->buildProductAttribute($product,$attr);
          $prod_attr->setValue($data->$val);
          $em->persist($prod_attr);
        }
      }
    }

    $em->flush();
  }

  private function buildProductAttribute(\Club\ShopBundle\Entity\Product $product, \Club\ShopBundle\Entity\Attribute $attr)
  {
    $prod_attr = new \Club\ShopBundle\Entity\ProductAttribute();
    $prod_attr->setProduct($product);
    $prod_attr->setAttribute($attr);

    return $prod_attr;
  }
}
