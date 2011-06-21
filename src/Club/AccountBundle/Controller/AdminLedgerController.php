<?php

namespace Club\AccountBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminLedgerController extends Controller
{
  /**
   * @Route("/account/ledger/{id}")
   * @Template()
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $ledgers = $em->getRepository('ClubAccountBundle:Ledger')->findBy(array(
      'account' => $id
    ));

    return array(
      'ledgers' => $ledgers
    );
  }
}
