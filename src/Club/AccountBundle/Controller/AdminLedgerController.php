<?php

namespace Club\AccountBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminLedgerController extends Controller
{
  /**
   * @Route("/account/ledger/expense")
   * @Template
   */
  public function expenseAction()
  {
    $ledger = new \Club\AccountBundle\Entity\Ledger();
    $form = $this->createForm(new \Club\AccountBundle\Form\Ledger(), $ledger);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();

        $em->persist($ledger);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('club_account_adminledger_index', array('id' => $ledger->getAccount()->getId())));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/account/ledger/income")
   * @Template
   */
  public function incomeAction()
  {
    $ledger = new \Club\AccountBundle\Entity\Ledger();
    $form = $this->createForm(new \Club\AccountBundle\Form\Ledger(), $ledger);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();

        $em->persist($ledger);
        $em->flush();

        $this->get('session')->setFlash('notice',$this->get('translator')->trans('Your changes are saved.'));
        return $this->redirect($this->generateUrl('club_account_adminledger_index', array('id' => $ledger->getAccount()->getId())));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Route("/account/ledger/{id}")
   * @Template()
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $filter = array(
      'account' => $id
    );
    $count = $em->getRepository('ClubAccountBundle:Ledger')->getCount($filter);
    $paginator = new \Club\UserBundle\Helper\Paginator($count, $this->generateUrl('club_account_adminledger_index',
      array('id' => $id
    )));
    $ledgers = $em->getRepository('ClubAccountBundle:Ledger')->getWithPagination($filter, null, $paginator->getOffset(), $paginator->getLimit());

    return array(
      'paginator' => $paginator,
      'ledgers' => $ledgers
    );
  }
}
