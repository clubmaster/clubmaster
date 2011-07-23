<?php

namespace Club\MenuBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterMenuEvent extends Event
{
  protected $menu;

  public function __construct($menu)
  {
    $this->menu = $menu;
  }

  public function getMenu()
  {
    return $this->menu;
  }

  public function setMenu($menu)
  {
    $this->menu = $menu;
  }
}
