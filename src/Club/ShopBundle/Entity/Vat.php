<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\Vat")
 * @ORM\Table(name="club_shop_vat")
 *
 */
class Vat
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
     * @var string $vat_name
     */
    private $vat_name;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var float $rate
     */
    private $rate;


    public function __toString()
    {
      return $this->getVatName();
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
     * Set vat_name
     *
     * @param string $vatName
     */
    public function setVatName($vatName)
    {
        $this->vat_name = $vatName;
    }

    /**
     * Get vat_name
     *
     * @return string $vatName
     */
    public function getVatName()
    {
        return $this->vat_name;
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
