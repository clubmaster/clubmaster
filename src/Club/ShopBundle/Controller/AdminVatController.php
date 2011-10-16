<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminVatController extends Controller
{
  /**
   * @Route("/shop/vat")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $vats = $em->getRepository('ClubShopBundle:Vat')->findAll();

    return array(
      'vats' => $vats
    );
  }

  /**
   * @Route("/shop/vat/new")
   * @Template()
   */
  public function newAction()
  {
    $vat = new \Club\ShopBundle\Entity\Vat();
    $res = $this->process($vat);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/vat/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $vat = $em->find('ClubShopBundle:Vat',$id);

    $res = $this->process($vat);

    if ($res instanceOf RedirectResponse)
      return $res;

    return array(
      'vat' => $vat,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/vat/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $vat = $em->find('ClubShopBundle:Vat',$this->getRequest()->get('id'));

    $em->remove($vat);
    $em->flush();

    $this->get('session')->setFlash('notify',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_shop_adminvat_index'));
  }

  protected function process($vat)
  {
    $form = $this->createForm(new \Club\ShopBundle\Form\Vat(), $vat);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($vat);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_shop_adminvat_index'));
      }
    }

    return $form;
  }
}
