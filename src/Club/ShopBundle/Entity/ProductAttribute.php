<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\ProductAttribute")
 * @ORM\Table(name="club_shop_product_attribute")
 *
 */
class ProductAttribute
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $value
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="cascade")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Attribute")
     */
    private $attribute;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return float $value
     */
    public function getValue()
    {
        return $this->value;
    }

    public function setProduct($product)
    {
      $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setAttribute($attribute)
    {
      $this->attribute = $attribute;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getTimeInterval()
    {
      $date1 = new \DateTime();
      $date2 = new \DateTime();
      $i = new \DateInterval('P'.$this->getValue());
      $date2->add($i);

      return $this->formatDateDiff($date1, $date2);
    }

    /**
     * A sweet interval formatting, will use the two biggest interval parts.
     * On small intervals, you get minutes and seconds.
     * On big intervals, you get months and days.
     * Only the two biggest parts are used.
     *
     * @param DateTime $start
     * @param DateTime|null $end
     * @return string
     */
    public function formatDateDiff($start, $end=null) {
      if(!($start instanceof \DateTime)) {
        $start = new \DateTime($start);
      }

      if($end === null) {
        $end = new \DateTime();
      }

      if(!($end instanceof \DateTime)) {
        $end = new \DateTime($start);
      }

      $interval = $end->diff($start);
      $doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals

      $format = array();
      if($interval->y !== 0) {
        $format[] = "%y ".$doPlural($interval->y, "year");
      }
      if($interval->m !== 0) {
        $format[] = "%m ".$doPlural($interval->m, "month");
      }
      if($interval->d !== 0) {
        $format[] = "%d ".$doPlural($interval->d, "day");
      }
      if($interval->h !== 0) {
        $format[] = "%h ".$doPlural($interval->h, "hour");
      }
      if($interval->i !== 0) {
        $format[] = "%i ".$doPlural($interval->i, "minute");
      }
      if($interval->s !== 0) {
        if(!count($format)) {
          return "less than a minute ago";
        } else {
          $format[] = "%s ".$doPlural($interval->s, "second");
        }
      }

      // We use the two biggest parts
      if(count($format) > 1) {
        $format = array_shift($format)." and ".array_shift($format);
      } else {
        $format = array_pop($format);
      }

      // Prepend 'since ' or whatever you like
      return $interval->format($format);
    }
}
