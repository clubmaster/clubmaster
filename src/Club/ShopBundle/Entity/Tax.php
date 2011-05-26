<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\Tax")
 * @ORM\Table(name="club_shop_tax")
 *
 */
class Tax
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
     * @var string $tax_name
     */
    private $tax_name;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var float $rate
     */
    private $rate;


    public function __toString()
    {
      return $this->getTaxName();
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

    /**
     * Set tax_name
     *
     * @param string $taxName
     */
    public function setTaxName($taxName)
    {
        $this->tax_name = $taxName;
    }

    /**
     * Get tax_name
     *
     * @return string $taxName
     */
    public function getTaxName()
    {
        return $this->tax_name;
    }

    /**
     * Set rate
     *
     * @param float $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get rate
     *
     * @return float $rate
     */
    public function getRate()
    {
        return $this->rate;
    }
}
