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
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
  /**
   * @Route("/task", name="admin_task")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();

    $tasks = $em->getRepository('\Club\TaskBundle\Entity\Task')->findAll();

    return array(
      'tasks' => $tasks
    );
  }

  /**
   * @Route("/task/disable/{id}", name="admin_task_disable")
   */
  public function disableAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $task = $em->find('\Club\TaskBundle\Entity\Task',$id);
    $task->setEnabled(0);

    $em->persist($task);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_task'));
  }

  /**
   * @Route("/task/enable/{id}", name="admin_task_enable")
   */
  public function enableAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $task = $em->find('\Club\TaskBundle\Entity\Task',$id);
    $task->setEnabled(1);

    $em->persist($task);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_task'));
  }

  /**
   * @Route("/task/run/{id}", name="admin_task_run")
   */
  public function runAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $task = $em->find('\Club\TaskBundle\Entity\Task',$id);
    $task->setNextRunAt(new \DateTime());
    $task->setLocked(0);

    $em->persist($task);
    $em->flush();

    return $this->redirect($this->generateUrl('admin_task'));
  }
}
