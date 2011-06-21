<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminSpecialController extends Controller
{
  /**
   * @Route("/shop/special", name="admin_shop_special")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $specials = $em->getRepository('\Club\ShopBundle\Entity\Special')->findAll();

    return array(
      'specials' => $specials
    );
  }

  /**
   * @Route("/shop/special/new", name="admin_shop_special_new")
   * @Template()
   */
  public function newAction()
  {
    $special = new \Club\ShopBundle\Entity\Special();
    $res = $this->process($special);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/special/edit/{id}", name="admin_shop_special_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $special = $em->find('Club\ShopBundle\Entity\Special',$id);

    $res = $this->process($special);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'special' => $special,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/special/delete/{id}", name="admin_shop_special_delete")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $special = $em->find('ClubShopBundle:Special',$this->getRequest()->get('id'));

    $em->remove($special);
    $em->flush();

    $this->get('session')->setFlash('notify',sprintf('Special %s deleted.',$special->getProduct()->getProductName()));

    return new RedirectResponse($this->generateUrl('admin_shop_special'));
  }

  protected function process($special)
  {
    $form = $this->get('form.factory')->create(new \Club\ShopBundle\Form\Special(), $special);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($special);
        $em->flush();

        $this->get('session')->setFlash('notice','Your changes were saved!');

        return new RedirectResponse($this->generateUrl('admin_shop_special'));
      }
    }

    return $form;
  }
}
