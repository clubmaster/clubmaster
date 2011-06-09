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
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
  /**
   * @Route("/task", name="admin_task")
   * @Template()
   */
  public function indexAction()
  {
    $em = $this->get('doctrine')->getEntityManager();

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
    $em = $this->get('doctrine')->getEntityManager();

    $task = $em->find('\Club\TaskBundle\Entity\Task',$id);
    $task->setEnabled(0);

    $em->persist($task);
    $em->flush();

    return new RedirectResponse($this->generateUrl('admin_task'));
  }

  /**
   * @Route("/task/enable/{id}", name="admin_task_enable")
   */
  public function enableAction($id)
  {
    $em = $this->get('doctrine')->getEntityManager();

    $task = $em->find('\Club\TaskBundle\Entity\Task',$id);
    $task->setEnabled(1);

    $em->persist($task);
    $em->flush();

    return new RedirectResponse($this->generateUrl('admin_task'));
  }

  /**
   * @Route("/task/run/{id}", name="admin_task_run")
   */
  public function runAction($id)
  {
    $em = $this->get('doctrine')->getEntityManager();

    $task = $em->find('\Club\TaskBundle\Entity\Task',$id);
    $task->setNextRunAt(new \DateTime());

    $em->persist($task);
    $em->flush();

    return new RedirectResponse($this->generateUrl('admin_task'));
  }
}
