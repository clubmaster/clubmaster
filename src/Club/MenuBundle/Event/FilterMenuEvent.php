<?php

namespace Club\MenuBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterMenuEvent extends Event
{
  protected $menu;
  protected $menu_right;
  protected $menu_dash;

  public function __construct()
  {
    $this->menu = array();;
    $this->menu_right = array();
    $this->menu_dash = array();
  }

  public function getMenu()
  {
    return $this->menu;
  }

  public function setMenu($menu)
  {
    $this->menu = $menu;
  }

  public function appendItem($menu)
  {
    foreach ($menu as $key => $item) {
      if (isset($this->menu[$key])) throw new \Exception('Cannot overwrite menu item: '.$key);

      $this->menu[$key] = $item;
    }
  }

  public function getMenuRight()
  {
    return $this->menu_right;
  }

  public function setMenuRight($menu_right)
  {
    $this->menu_right = $menu_right;
  }

  public function appendItemRight($menu_right)
  {
    foreach ($menu_right as $key => $item) {
      if (isset($this->menu_right[$key])) throw new \Exception('Cannot overwrite menu item: '.$key);

      $this->menu_right[$key] = $item;
    }
  }
}
