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
   * @Route("/log/action/page/{page}", name="club_log_log_index_page")
   * @Route("/log/action")
   * @Template()
   */
  public function indexAction($page = null)
  {
    $em = $this->getDoctrine()->getManager();

    $logs_count = $em->getRepository('ClubLogBundle:Log')->getCount();
    $nav = $this->get('club_paginator.paginator')
        ->init(50, $logs_count, $page, 'club_log_log_index_page');

    $logs = $em->getRepository('ClubLogBundle:Log')->getWithPagination($nav->getOffset(), $nav->getLimit());

    return array(
      'logs' => $logs,
      'nav' => $nav,
    );
  }

  /**
   * @Route("/log/action/{id}")
   * @Template()
   */
  public function showAction($id)
  {
    $em = $this->getDoctrine()->getManager();

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

    $em = $this->getDoctrine()->getManager();
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
