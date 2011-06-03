<?php

namespace Club\AccountBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LedgerController extends Controller
{
  /**
   * @Route("/account/ledger", name="account_ledger")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $user = $this->get('security.context')->getToken()->getUser();

    $ledgers = $em->getRepository('\Club\AccountBundle\Entity\Ledger')->findBy(array(
      'user' => $user->getId()
    ));

    return array(
      'ledgers' => $ledgers
    );
  }

  /**
   * @Route("/account/ledger/edit/{id}", name="account_ledger_edit")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->get('doctrine.orm.entity_manager');
    $ledger = $em->find('\Club\AccountBundle\Entity\Ledger',$id);

    return array(
      'ledger' => $ledger,
    );
  }

  /**
   * @Route("/account/ledger/batch", name="account_ledger_batch")
   */
  public function batchAction()
  {
  }
}
