<?php

namespace Club\ShopBundle\Helper;

class Product
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  public function getAttribute(\Club\ShopBundle\Entity\Product $product)
  {
    $attr = new \Club\ShopBundle\Model\Attribute();
    foreach ($product->getProductAttributes() as $a) {
      $v = 'set'.preg_replace("/_/", "", $a->getAttribute());

      if ($a->getAttribute() == 'location') {
        $res = new \Doctrine\Common\Collections\ArrayCollection();
        $locations = $this->em->getRepository('ClubUserBundle:Location')->getByIds(explode(",", $a->getValue()));
        foreach ($locations as $location) {
          $res[] = $location;
        }
        $attr->$v($res);
      } else {
        $attr->$v($a->getValue());
      }
    }

    return $attr;
  }
}
