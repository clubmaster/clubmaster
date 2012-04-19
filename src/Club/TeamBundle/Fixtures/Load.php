<?php

namespace Club\TeamBundle\Fixtures;

class Load
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function onFixturesInit()
  {
    $this->initLevel();

    $this->em->flush();
  }

  private function initLevel()
  {
    $levels = array(
      'Easy',
      'Medium',
      'Hard'
    );

    foreach ($levels as $level) {
      $r = $this->em->getRepository('ClubTeamBundle:Level')->findOneBy(array(
        'level_name' => $level
      ));

      if (!$r) {
        $l = new \Club\TeamBundle\Entity\Level();
        $l->setLevelName($level);
        $this->em->persist($l);
      }
    }
  }
}
