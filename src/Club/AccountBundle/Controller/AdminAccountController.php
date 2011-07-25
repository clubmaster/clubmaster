<?php

namespace Club\AccountBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminAccountController extends Controller
{
  /**
   * @Route("/account")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $user = $this->get('security.context')->getToken()->getUser();

    $accounts = $em->getRepository('ClubAccountBundle:Account')->findAll();

    return array(
      'accounts' => $accounts
    );
  }

  /**
   * @Route("/account/account/new")
   * @Template
   */
  public function newAction()
  {
    $account = new \Club\AccountBundle\Entity\Account();
    $form = $this->createForm(new \Club\AccountBundle\Form\Account(), $account);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();

        $em->persist($account);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('club_account_adminaccount_index'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/account/account/edit/{id}")
   * @Template
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $account = $em->find('ClubAccountBundle:Account', $id);

    $form = $this->createForm(new \Club\AccountBundle\Form\Account(), $account);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();

        $em->persist($account);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('club_account_adminaccount_index'));
      }
    }

    return array(
      'account' => $account,
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/account/account/delete/{id}")
   * @Template
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $account = $em->find('ClubAccountBundle:Account', $id);

    $em->remove($account);
    $em->flush();

    $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
    return $this->redirect($this->generateUrl('club_account_adminaccount_index'));
  }
}
