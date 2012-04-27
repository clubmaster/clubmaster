<?php

namespace Club\PasskeyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/admin/passkey")
 */
class AdminPasskeyController extends Controller
{
  /**
   * @Route("/")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $passkeys = $em->getRepository('ClubPasskeyBundle:Passkey')->findAll();
    return array(
      'passkeys' => $passkeys
    );
  }

  /**
   * @Route("/new")
   * @Template()
   */
  public function newAction()
  {
    $passkey = new \Club\PasskeyBundle\Entity\Passkey();
    $form = $this->createForm(new \Club\PasskeyBundle\Form\Passkey(), $passkey);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();

        $em->persist($passkey);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $passkey = $em->find('ClubPasskeyBundle:Passkey',$id);
    $form = $this->createForm(new \Club\PasskeyBundle\Form\Passkey(), $passkey);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($passkey);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
      }
    }

    return array(
      'passkey' => $passkey,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $passkey = $em->find('ClubPasskeyBundle:Passkey',$this->getRequest()->get('id'));

    $em->remove($passkey);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
  }
}
