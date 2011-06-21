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
use Symfony\Component\HttpFoundation\Response;

class LogController extends Controller
{
  /**
   * @Route("/log", name="admin_log")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $logs = $em->getRepository('ClubLogBundle:Log')->findAll();
    $login_attempts = $em->getRepository('ClubUserBundle:LoginAttempt')->findAll();

    return array(
      'logs' => $logs,
      'login_attempts' => $login_attempts
    );
  }

  /**
   * @Route("/log/{id}")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $log = $em->find('ClubLogBundle:Log',$id);
    $log->setIsRead(1);

    $em->persist($log);
    $em->flush();

    return array(
      'log' => $log
    );
  }

  public function LogViewAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $logs = $em->getRepository('ClubLogBundle:Log')->findBy(array(
      'is_read' => 0,
      'severity' => 'critical'
    ));

    return $this->render('ClubLogBundle:Log:log_view.html.twig',array(
      'logs' => $logs
    ));
  }
}
