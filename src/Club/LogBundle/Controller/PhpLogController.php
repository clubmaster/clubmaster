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

class PhpLogController extends Controller
{
  /**
   * @Route("/log/php")
   * @Template()
   */
  public function indexAction()
  {
    $raw = $this->read_file($this->get('kernel')->getRootDir().'/logs/'.$this->get('kernel')->getEnvironment().'.log', 100);

    $logs = array();
    foreach ($raw as $line) {
      var_dump($line);
      if (preg_match("/^[(.+)] (\w+)\.(\w+): (.*)$/", $line, $o)) {
        $logs[] = array(
          'date' => $o[1],
          'type' => $o[2],
          'severity' => $o[3],
          'message' => $o[4]
        );
      }
    }

    return array(
      'logs' => $logs,
    );
  }

  function read_file($file, $lines) {
    //global $fsize;
    $handle = fopen($file, "r");
    $linecounter = $lines;
    $pos = -2;
    $beginning = false;
    $text = array();
    while ($linecounter > 0) {
      $t = " ";
      while ($t != "\n") {
        if(fseek($handle, $pos, SEEK_END) == -1) {
          $beginning = true;
          break;
        }
        $t = fgetc($handle);
        $pos --;
      }
      $linecounter --;
      if ($beginning) {
        rewind($handle);
      }
      $text[$lines-$linecounter-1] = fgets($handle);
      if ($beginning) break;
    }
    fclose ($handle);
    return array_reverse($text);
  }
}
