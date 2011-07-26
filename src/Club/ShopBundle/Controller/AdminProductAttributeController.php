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
    $res = range(1,72);
    $months = array();
    foreach ($res as $i) {
      $months[$i] = $i;
    }
    $res = range(1,100);
    $tickets = array();
    foreach ($res as $i) {
      $tickets[$i] = $i;
    }
    $res = range(1,10);
    $pauses = array();
    foreach ($res as $i) {
      $pauses[$i] = $i;
    }

    $bool = array(
      1 => 'Yes'
    );

    $renewal = array(
      'A' => 'After expire',
      'Y' => 'Yearly',
    );

    $form = $this->createFormBuilder()
      ->add('Month','choice',array(
        'required' => false,
        'choices' => $months
      ))
      ->add('Ticket','choice',array(
        'required' => false,
        'choices' => $tickets
      ))
      ->add('AutoRenewal','choice',array(
        'required' => false,
        'choices' => $renewal,
        'label' => 'Auto Renewal'

      ))
      ->add('Lifetime','choice',array(
        'required' => false,
        'choices' => $bool
      ))
      ->add('AllowedPauses','choice',array(
        'required' => false,
        'choices' => $pauses,
        'label' => 'Allowed Pauses'
      ))
      ->add('StartDate','date', array(
        'required' => false,
        'label' => 'Start date'
      ))
      ->add('ExpireDate','date', array(
        'required' => false,
        'label' => 'Expire date'
      ))
      ->add('Location','entity',array(
        'class' => 'Club\UserBundle\Entity\Location',
        'multiple' => true,
        'required' => false
      ))
      ->getForm();

    $form->setData($this->getData($product));
    return $form;
  }

  private function getData($product)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $arr = array();
    foreach ($product->getProductAttributes() as $attr) {
      if ($attr->getAttribute()->getAttributeName() == 'Location') {
        $res = new \Doctrine\Common\Collections\ArrayCollection();
        $locations = $em->getRepository('ClubUserBundle:Location')->getByIds(explode(",", $attr->getValue()));
        foreach ($locations as $location) {
          $res[] = $location;
        }
        $arr[$attr->getAttribute()->getAttributeName()] = $res;

      } elseif ($attr->getAttribute()->getAttributeName() == 'StartDate' || $attr->getAttribute()->getAttributeName() == 'ExpireDate') {
        $arr[$attr->getAttribute()->getAttributeName()] = new \DateTime($attr->getValue());
      } else {
        $arr[$attr->getAttribute()->getAttributeName()] = $attr->getValue();
      }
    }

    return $arr;
  }

  private function setData(\Club\ShopBundle\Entity\Product $product, $data)
  {
    $em = $this->getDoctrine()->getEntityManager();

    foreach ($em->getRepository('ClubShopBundle:Attribute')->findAll() as $attr) {
      $prod_attr = $em->getRepository('ClubShopBundle:ProductAttribute')->findOneBy(array(
        'product' => $product->getId(),
        'attribute' => $attr->getId()
      ));

      if (($attr->getAttributeName() == 'StartDate' || $attr->getAttributeName() == 'ExpireDate') && $data[$attr->getAttributeName()] != '')
        $data[$attr->getAttributeName()] = $data[$attr->getAttributeName()]->format('Y-m-d');

      if ($attr->getAttributeName() == 'Location') {
        $str = '';
        foreach ($data[$attr->getAttributeName()] as $l) {
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

        if ($prod_attr && $data[$attr->getAttributeName()] == '') {
          $em->remove($prod_attr);

        } elseif ($prod_attr && $data[$attr->getAttributeName()] != '') {
          $prod_attr->setValue($data[$attr->getAttributeName()]);
          $em->persist($prod_attr);

        } elseif (!$prod_attr && $data[$attr->getAttributeName()] != '') {
          $prod_attr = $this->buildProductAttribute($product,$attr);
          $prod_attr->setValue($data[$attr->getAttributeName()]);
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
