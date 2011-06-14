<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Club\LogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LogController extends Controller
{
  /**
   * @Route("/log", name="admin_log")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->get('doctrine')->getEntityManager();

    $logs = $em->getRepository('ClubLogBundle:Log')->findAll();
    $login_attempts = $em->getRepository('ClubUserBundle:LoginAttempt')->findAll();

    return array(
      'logs' => $logs,
      'login_attempts' => $login_attempts
    );
  }
}
