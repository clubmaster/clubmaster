<?php

namespace Club\MenuBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FilterMenuEvent extends Event
{
  protected $menu;

  public function __construct()
  {
    $this->menu = array();
  }

  public function getMenu()
  {
    return $this->menu;
  }

  public function setMenu($menu)
  {
    $this->menu = $menu;
  }

  public function appendMenu($menu)
  {
      foreach ($menu as $key => $item) {
          if (isset($this->menu[$key])) throw new \Exception('Cannot overwrite menu item: '.$key);

          $this->menu[$key] = $item;
      }
  }

  public function appendItem($menu)
  {
      if (isset($menu['header']) && $this->headerExists($menu['header'])) {
          $h = $menu['header'];

          $res = $this->getItemByHeader($h);
          foreach ($menu['items'] as $i) {
            $res['item']['items'][] = $i;
          }

          $this->menu[$res['key']] = $res['item'];
      } else {
          $this->menu[] = $menu;
      }
  }

  public function headerExists($query)
  {
      foreach ($this->menu as $item) {
          if (isset($item['header']) && $item['header'] == $query)
              return true;
      }

      return false;
  }

  public function getItemByHeader($query)
  {
      foreach ($this->menu as $key => $item) {
          if (isset($item['header']) && $item['header'] == $query)
              return array(
                  'key' => $key,
                  'item' => $item
              );
      }

      return false;
  }
}
