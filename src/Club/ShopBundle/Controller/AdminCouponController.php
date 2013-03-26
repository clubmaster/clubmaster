<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class AdminCouponController extends Controller
{
  /**
   * @Route("/shop/coupon")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $coupons = $em->getRepository('ClubShopBundle:Coupon')->findAll();

    return array(
      'coupons' => $coupons
    );
  }

  /**
   * @Route("/shop/coupon/new")
   * @Template()
   */
  public function newAction()
  {
    $coupon = new \Club\ShopBundle\Entity\Coupon();
    $res = $this->process($coupon);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/coupon/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $coupon = $em->find('ClubShopBundle:Coupon',$id);

    $res = $this->process($coupon);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'coupon' => $coupon,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/coupon/expire/{id}")
   */
  public function expireAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $coupon = $em->find('ClubShopBundle:Coupon',$id);

    $coupon->setExpireAt(new \DateTime());
    $em->persist($coupon);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Coupon expired.'));

    return $this->redirect($this->generateUrl('club_shop_admincoupon_index'));
  }

  /**
   * @Route("/shop/coupon/log/{id}")
   * @Template()
   */
  public function logAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $coupons = $em->getRepository('ClubShopBundle:CouponLog')->findBy(array(
      'coupon' => $id
    ));

    return array(
      'coupons' => $coupons
    );
  }

  protected function process($coupon)
  {
    $form = $this->createForm(new \Club\ShopBundle\Form\Coupon(), $coupon);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($coupon);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_shop_admincoupon_index'));
      }
    }

    return $form;
  }
}
