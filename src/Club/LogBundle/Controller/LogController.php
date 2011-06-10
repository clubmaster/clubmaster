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

    $logs = $em->getRepository('\Club\LogBundle\Entity\Log')->findAll();

    return array(
      'logs' => $logs
    );
  }

  /**
   * @Route("/log/disable/{id}", name="admin_log_disable")
   */
  public function disableAction($id)
  {
    $em = $this->get('doctrine')->getEntityManager();

    $log = $em->find('\Club\LogBundle\Entity\Log',$id);
    $log->setEnabled(0);

    $em->persist($log);
    $em->flush();

    return new RedirectResponse($this->generateUrl('admin_log'));
  }

  /**
   * @Route("/log/enable/{id}", name="admin_log_enable")
   */
  public function enableAction($id)
  {
    $em = $this->get('doctrine')->getEntityManager();

    $log = $em->find('\Club\LogBundle\Entity\Log',$id);
    $log->setEnabled(1);

    $em->persist($log);
    $em->flush();

    return new RedirectResponse($this->generateUrl('admin_log'));
  }

  /**
   * @Route("/log/run/{id}", name="admin_log_run")
   */
  public function runAction($id)
  {
    $em = $this->get('doctrine')->getEntityManager();

    $log = $em->find('\Club\LogBundle\Entity\Log',$id);
    $log->setNextRunAt(new \DateTime());

    $em->persist($log);
    $em->flush();

    return new RedirectResponse($this->generateUrl('admin_log'));
  }
}
