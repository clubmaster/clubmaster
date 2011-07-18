<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CouponController extends Controller
{
  /**
   * @Route("/shop/coupon/add")
   * @Template()
   */
  public function addAction()
  {
    $form = $this->createFormBuilder()
      ->add('coupon_key','text')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $data = $form->getData();

        $em = $this->getDoctrine()->getEntityManager();
        $coupon = $em->getRepository('ClubShopBundle:Coupon')->findOneBy(array(
          'coupon_key' => $data['coupon_key']
        ));

        if ($coupon) {
          $this->get('session')->setFlash('notice','Your coupon has been added to the cart.');
        } else {
          $this->get('session')->setFlash('error','No such coupon.');
        }

        return $this->redirect($this->generateUrl('shop_checkout'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }
}
