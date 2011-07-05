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

    $logs_count = $em->getRepository('ClubLogBundle:Log')->getCount();
    $paginator = new \Club\UserBundle\Helper\Paginator($logs_count, $this->generateUrl('admin_log'));
    $logs = $em->getRepository('ClubLogBundle:Log')->getWithPagination($paginator->getOffset(), $paginator->getLimit());

    return array(
      'logs' => $logs,
      'paginator' => $paginator,
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
    $logs = array();

    if (!($res = $this->canWriteToMailerSpool()))
      $logs[] = 'Cannot write to mailer spool dir <strong>'.$this->container->getParameter('swiftmailer.spool.file.path').'</strong>';

    if (($res = $this->installerFileExists()))
      $logs[] = 'Remove installer file <strong>'.$this->get('kernel')->getRootDir().'/installer</strong>';

    $em = $this->getDoctrine()->getEntityManager();
    $l = $em->getRepository('ClubLogBundle:Log')->findBy(array(
      'is_read' => 0,
      'severity' => 'critical'
    ));

    if (count($l) > 0)
      $logs[] = 'You have <strong>'.count($l).' unread</strong> critical messages.';

    return $this->render('ClubLogBundle:Log:log_view.html.twig',array(
      'logs' => $logs,
    ));
  }

  private function canWriteToMailerSpool()
  {
    $path = $this->container->getParameter('swiftmailer.spool.file.path');

    if (is_writeable($path))
      return true;

    return false;
  }

  private function installerFileExists()
  {
    $remove_installer_file = 0;
    $installer_file = $this->get('kernel')->getRootDir().'/installer';

    if (file_exists($installer_file))
      return true;

    return false;
  }
}
