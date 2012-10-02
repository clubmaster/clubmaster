<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Club\TaskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin/task")
 */
class AdminTaskController extends Controller
{
  /**
   * @Route("", name="admin_task")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $tasks = $em->getRepository('ClubTaskBundle:Task')->findAll();

    return array(
      'tasks' => $tasks
    );
  }

  /**
   * @Route("/disable/{id}", name="admin_task_disable")
   */
  public function disableAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $task = $em->find('ClubTaskBundle:Task',$id);
    $task->setEnabled(0);

    $em->persist($task);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_task'));
  }

  /**
   * @Route("/enable/{id}", name="admin_task_enable")
   */
  public function enableAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $task = $em->find('ClubTaskBundle:Task',$id);
    $task->setEnabled(1);

    $em->persist($task);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_task'));
  }

  /**
   * @Route("/run/{id}", name="admin_task_run")
   */
  public function runAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $task = $em->find('ClubTaskBundle:Task',$id);
    $task->setNextRunAt(new \DateTime());
    $task->setLocked(0);

    $em->persist($task);
    $em->flush();

    $this->get('session')->setFlash('notice', $this->get('translator')->trans('Job has been executed'));

    return $this->redirect($this->generateUrl('admin_task'));
  }

  /**
   * @Route("/edit/{id}")
   * @Template()
   */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $task = $em->find('ClubTaskBundle:Task',$id);

    $form = $this->createForm(new \Club\TaskBundle\Form\Task, $task);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bind($this->getRequest());
      if ($form->isValid()) {
        $em->persist($task);
        $em->flush();
      }
    }

    return array(
      'form' => $form->createView(),
      'task' => $task
    );
  }
}
