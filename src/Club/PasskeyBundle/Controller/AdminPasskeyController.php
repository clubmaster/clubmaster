<?php

namespace Club\PasskeyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        return $this->redirect($this->generateUrl('club_passkey_adminpasskey_edit', array(
          'id' => $passkey->getId()
        )));
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
    $user_form = $this->createFormBuilder()
      ->add('user_id', 'hidden')
      ->add('user', 'text')
      ->getForm();

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
      'form' => $form->createView(),
      'user_form' => $user_form->createView()
    );
  }

  /**
   * @Route("/user/{id}")
   * @Template()
   */
  public function userAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $passkey = $em->find('ClubPasskeyBundle:Passkey',$id);
    $form = $this->createFormBuilder()
      ->add('user_id', 'hidden')
      ->add('user', 'text')
      ->getForm();

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();

        $r = $form->getData();
        $user = $em->find('ClubUserBundle:User', $r['user_id']);

        if (!$user) {
          $this->get('session')->setFlash('error',$this->get('translator')->trans('No such user'));

          return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
        }

        $passkey->setUser($user);
        $em->persist($passkey);

        $em->flush();
        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

        return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
      }
    }

    return array(
      'passkey' => $passkey,
      'form' => $form->createView(),
      'user_form' => $user_form->createView()
    );
  }

  /**
   * @Route("/reset/{id}")
   */
  public function resetAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $passkey = $em->find('ClubPasskeyBundle:Passkey',$this->getRequest()->get('id'));
    $passkey->setUser(null);

    $em->flush();
    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));

    return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
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
