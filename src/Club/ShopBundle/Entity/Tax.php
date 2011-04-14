<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\Tax")
 * @orm:Table(name="club_shop_tax")
 *
 */
class Tax
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @orm:Column(type="string")
     *
     * @var string $tax_name
     */
    private $tax_name;

    /**
     * @orm:Column(type="decimal")
     *
     * @var float $rate
     */
    private $rate;


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
