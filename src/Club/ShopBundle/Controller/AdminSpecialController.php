<?php

namespace Club\ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin")
 */
class AdminSpecialController extends Controller
{
  /**
   * @Route("/shop/special")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $specials = $em->getRepository('ClubShopBundle:Special')->findAll();

    return array(
      'specials' => $specials
    );
  }

  /**
   * @Route("/shop/special/new")
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
   * @Route("/shop/special/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $special = $em->find('ClubShopBundle:Special',$id);

    $res = $this->process($special);

    if ($res instanceOf RedirectResponse)

      return $res;

    return array(
      'special' => $special,
      'form' => $res->createView()
    );
  }

  /**
   * @Route("/shop/special/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $special = $em->find('ClubShopBundle:Special',$id);

    $em->remove($special);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_shop_adminspecial_index'));
  }

  protected function process($special)
  {
    $form = $this->createForm(new \Club\ShopBundle\Form\Special(), $special);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($special);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_shop_adminspecial_index'));
      }
    }

    return $form;
  }
}
