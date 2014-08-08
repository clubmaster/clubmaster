<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Club\ShopBundle\Entity\Shipping;
use Club\ShopBundle\Form\ShippingType;

/**
 * @Route("/admin")
 */
class AdminShippingController extends Controller
{
  /**
   * @Route("/shop/shipping", name="admin_shop_shipping")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $shippings = $em->getRepository('ClubShopBundle:Shipping')->findAll();

    return array(
      'shippings' => $shippings
    );
  }

  /**
   * @Route("/shop/shipping/new", name="admin_shop_shipping_new")
   * @Template()
   */
  public function newAction()
  {
    $shipping = new Shipping();
    $res = $this->process($shipping);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/shipping/edit/{id}", name="admin_shop_shipping_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $shipping = $em->find('ClubShopBundle:Shipping',$id);

    $res = $this->process($shipping);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'shipping' => $shipping,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/shipping/delete/{id}", name="admin_shop_shipping_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $shipping = $em->find('ClubShopBundle:Shipping',$this->getRequest()->get('id'));

    $em->remove($shipping);
    $em->flush();

    $this->get('club_extra.flash')->addNotice();

    return $this->redirect($this->generateUrl('admin_shop_shipping'));
  }

  protected function process($shipping)
  {
    $form = $this->createForm(new ShippingType(), $shipping);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($shipping);
        $em->flush();

        $this->get('club_extra.flash')->addNotice();

        return $this->redirect($this->generateUrl('admin_shop_shipping'));
      }
    }

    return $form;
  }
}
