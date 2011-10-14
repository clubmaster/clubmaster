<?php

namespace Club\APIBundle\Helper;

class Encode
{
  public function encode($input)
  {
    return json_encode($input);
  }
}
