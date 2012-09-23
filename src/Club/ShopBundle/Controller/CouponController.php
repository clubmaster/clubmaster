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
      $form->bind($this->getRequest());

      if ($form->isValid()) {
        $data = $form->getData();

        $em = $this->getDoctrine()->getEntityManager();
        $coupon = $em->getRepository('ClubShopBundle:Coupon')->getCoupon($data['coupon_key']);

        if (!$coupon) {
          $this->get('session')->setFlash('error',$this->get('translator')->trans('No such coupon.'));

        } elseif (count($coupon->getCouponLog()) >= $coupon->getMaxUsage()) {
          $this->get('session')->setFlash('error',$this->get('translator')->trans('Coupon use too many times'));
        } else {
          $product = array(
            'product_name' => 'Coupon #'.$coupon->getCouponKey(),
            'price' => $coupon->getValue()*-1,
            'type' => 'coupon'
          );

          $this->get('cart')->addToCart($product);
          $event = new \Club\ShopBundle\Event\FilterCouponEvent($coupon);
          $this->get('event_dispatcher')->dispatch(\Club\ShopBundle\Event\Events::onCouponUse, $event);

          $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your coupon has been added to the cart.'));
        }

        return $this->redirect($this->generateUrl('shop_checkout'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }
}
