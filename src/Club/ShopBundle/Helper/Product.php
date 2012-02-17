<?php

namespace Club\ShopBundle\Helper;

class Product
{
  public function getAttribute(\Club\ShopBundle\Entity\Product $product)
  {
    $attr = new \Club\ShopBundle\Model\Attribute();
    foreach ($product->getProductAttributes() as $a) {
      $v = 'set'.preg_replace("/_/", "", $a->getAttribute());
      $attr->$v($a->getValue());
    }

    return $attr;
  }
}
