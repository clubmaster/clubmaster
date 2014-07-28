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
   * @Route("")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
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
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();

        $em->persist($passkey);
        $em->flush();

        $this->get('club_user.flash')->addNotice();

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
    $em = $this->getDoctrine()->getManager();
    $passkey = $em->find('ClubPasskeyBundle:Passkey',$id);
    $form = $this->createForm(new \Club\PasskeyBundle\Form\Passkey(), $passkey);
    $user_form = $this->createForm(new \Club\UserBundle\Form\UserAjax());

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($passkey);
        $em->flush();

        $this->get('club_user.flash')->addNotice();

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
    $em = $this->getDoctrine()->getManager();
    $passkey = $em->find('ClubPasskeyBundle:Passkey',$id);
    $form = $this->createForm(new \Club\UserBundle\Form\UserAjax());

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();

        $user = $form->get('user')->getData();

        $passkey->setUser($user);
        $em->persist($passkey);

        $em->flush();
        $this->get('club_user.flash')->addNotice();

        return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
      } else {
          foreach ($form->get('user')->getErrors() as $error) {
              $this->get('session')->getFlashBag()->add('error',$error->getMessage());
          }

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
    $em = $this->getDoctrine()->getManager();
    $passkey = $em->find('ClubPasskeyBundle:Passkey',$this->getRequest()->get('id'));
    $passkey->setUser(null);

    $em->flush();

    $this->get('club_user.flash')->addNotice();

    return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
  }

  /**
   * @Route("/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $passkey = $em->find('ClubPasskeyBundle:Passkey',$this->getRequest()->get('id'));

    $em->remove($passkey);
    $em->flush();

    $this->get('club_user.flash')->addNotice();

    return $this->redirect($this->generateUrl('club_passkey_adminpasskey_index'));
  }
}
