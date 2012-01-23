<?php

namespace Club\APIBundle\Helper;

class Encode
{
  public function encode($input)
  {
    $res = array(
      'apiVersion' => '1',
      'data' => $input
    );

    return json_encode($res);
  }

  public function encodeError($input)
  {
    $res = array(
      'apiVersion' => '1',
      'error_msg' => $input
    );

    return json_encode($res);
  }

}
