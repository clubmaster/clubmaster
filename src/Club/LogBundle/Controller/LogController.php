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
    $remove_installer_file = 0;
    
    $file = preg_replace("/\/src\/Club\/LogBundle\/Controller/","",__DIR__).'/installer';
    if (file_exists($file))
      $remove_installer_file = $file;

    $em = $this->getDoctrine()->getEntityManager();

    $logs = $em->getRepository('ClubLogBundle:Log')->findBy(array(
      'is_read' => 0,
      'severity' => 'critical'
    ));

    return $this->render('ClubLogBundle:Log:log_view.html.twig',array(
      'logs' => $logs,
      'remove_installer_file' => $remove_installer_file
    ));
  }
}
