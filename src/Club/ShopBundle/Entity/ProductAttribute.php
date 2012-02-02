<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\ProductAttributeRepository")
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
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $value
     */
    protected $value;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $attribute
     */
    protected $attribute;

    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="cascade")
     */
    protected $product;


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
      $date1 = new \Club\UserBundle\Helper\DateTime();
      $date2 = new \Club\UserBundle\Helper\DateTime();
      $i = new \DateInterval('P'.$this->getValue());
      $date2->add($i);

      return $date2->formatDateDiff($date1, $date2);
    }
}
