<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\AttributeRepository")
 * @ORM\Table(name="club_shop_attribute")
 *
 */
class Attribute
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
     * @var string $attribute_name
     */
    protected $attribute_name;

    public function __toString()
    {
      return $this->getAttributeName();
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    public function setAttributeName($attribute_name)
    {
        $this->attribute_name = $attribute_name;
    }

    public function getAttributeName()
    {
        return $this->attribute_name;
    }
}
