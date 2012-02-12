<?php

namespace Club\UserBundle\Helper\Locale;

class Locale
{
  public function getAll()
  {
    return array(
      'en' >= 'English',
      'da' => 'Danish',
    );
  }
}
