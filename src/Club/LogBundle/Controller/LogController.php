<?php

namespace Club\LogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin")
 */
class LogController extends Controller
{
  /**
   * @Route("/log/action/offset/{offset}", name="club_log_log_index_offset")
   * @Route("/log/action")
   * @Template()
   */
  public function indexAction($offset = null)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $logs_count = $em->getRepository('ClubLogBundle:Log')->getCount();
    $paginator = $this->get('club_paginator.paginator');
    $paginator->init($logs_count, $offset);
    $paginator->setCurrentUrl('club_log_log_index_offset');

    $logs = $em->getRepository('ClubLogBundle:Log')->getWithPagination($paginator->getOffset(), $paginator->getLimit());

    return array(
      'logs' => $logs,
      'paginator' => $paginator,
    );
  }

  /**
   * @Route("/log/action/{id}")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $log = $em->find('ClubLogBundle:Log',$id);
    $log->setNew(0);

    $em->persist($log);
    $em->flush();

    return array(
      'log' => $log
    );
  }

  public function LogViewAction()
  {
    $logs = array();

    if (!($res = $this->canWriteToUploadPath()))
      $logs[] = $this->get('translator')->trans('Cannot write to upload path <strong>%path%</strong>',array('%path%' => $this->container->getParameter('upload_path')));

    if (($res = $this->installerFileExists()))
      $logs[] = $this->get('translator')->trans('Remove installer file <strong>%path%</strong>', array('%path%' => $this->get('kernel')->getRootDir().'/installer'));

    $em = $this->getDoctrine()->getEntityManager();
    $l = $em->getRepository('ClubLogBundle:Log')->findBy(array(
      'new' => 1,
      'severity' => 'critical'
    ));

    if (count($l) > 0)
      $logs[] = $this->get('translator')->transChoice(
        'You have an unread critical message.|You have %amount% unread critical messages.',
        count($l),
        array('%amount%' => count($l))
      );

    return $this->render('ClubLogBundle:Log:log_view.html.twig',array(
      'logs' => $logs,
    ));
  }

  private function canWriteToUploadPath()
  {
    $path = $this->container->getParameter('upload_path');

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
