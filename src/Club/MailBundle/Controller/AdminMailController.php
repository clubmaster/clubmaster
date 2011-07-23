<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Club\MailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminMailController extends Controller
{
  /**
   * @Route("/mail")
   * @Template()
   */
  public function indexAction()
  {
    $path = preg_replace("/Controller$/","",__DIR__);
    $res = scandir($path.'/Resources/views/Template/');
    $files = array();

    foreach ($res as $file) {
      if ($file != '.' && $file != '..') {
        $files[] = array(
          'event' => preg_replace("/.html.twig$/","",$file),
          'path' => $path.$file
        );
      }
    }

    return array(
      'files' => $files
    );
  }

  /**
   * @Route("/mail/show/{event}")
   * @Template()
   */
  public function showAction($event)
  {
    $path = preg_replace("/Controller$/","",__DIR__);
    $file = file_get_contents($path.'Resources/views/Template/'.$event.'.html.twig');

    return array(
      'file' => $file
    );
  }
}
