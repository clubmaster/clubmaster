<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Club\MailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MailLogController extends Controller
{
  /**
   * @Route("/log/mail")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $logs = $em->getRepository('ClubMailBundle:Log')->findBy(
      array(),
      array('id' => 'DESC'),
      50
    );

    return array(
      'logs' => $logs
    );
  }

  /**
   * @Route("/log/mail/{id}")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $log = $em->find('ClubMailBundle:Log',$id);

    return array(
      'log' => $log
    );
  }
}
