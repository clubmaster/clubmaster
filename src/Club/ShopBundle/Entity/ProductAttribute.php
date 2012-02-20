<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\ProductAttributeRepository")
 * @ORM\Table(name="club_shop_product_attribute")
 * @ORM\HasLifeCycleCallbacks()
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
     * @ORM\Column(type="datetime")
     *
     * @var date $created_at
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var date $updated_at
     */
    protected $updated_at;

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

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }
}
