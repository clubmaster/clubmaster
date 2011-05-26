<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\Currency")
 * @ORM\Table(name="club_currency")
 */
class Currency
{
    /**
     * @ORM\id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $currency_name
     */
    private $currency_name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $code
     */
    private $code;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $symbol_left
     */
    private $symbol_left;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $symbol_right
     */
    private $symbol_right;

    /**
     * @ORM\Column(type="string")
     * @var string $decimal_places
     */
    private $decimal_places;

    /**
     * @ORM\Column(type="decimal")
     *
     * @var float $value
     */
    private $value;


    public function __toString()
    {
      return $this->getCurrencyName();
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
     * Set currency_name
     *
     * @param string $currency_name
     */
    public function setCurrencyName($currencyName)
    {
        $this->currency_name = $currencyName;
    }

    /**
     * Get currencyName
     *
     * @return string $currency_name
     */
    public function getCurrencyName()
    {
        return $this->currency_name;
    }

    /**
     * Set code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set symbol_left
     *
     * @param string $symbolLeft
     */
    public function setSymbolLeft($symbolLeft)
    {
        $this->symbol_left = $symbolLeft;
    }

    /**
     * Get symbol_left
     *
     * @return string $symbolLeft
     */
    public function getSymbolLeft()
    {
        return $this->symbol_left;
    }

    /**
     * Set symbol_right
     *
     * @param string $symbolRight
     */
    public function setSymbolRight($symbolRight)
    {
        $this->symbol_right = $symbolRight;
    }

    /**
     * Get symbol_right
     *
     * @return string $symbolRight
     */
    public function getSymbolRight()
    {
        return $this->symbol_right;
    }

    /**
     * Set decimal_places
     *
     * @param string $decimalPlaces
     */
    public function setDecimalPlaces($decimalPlaces)
    {
        $this->decimal_places = $decimalPlaces;
    }

    /**
     * Get decimal_places
     *
     * @return string $decimalPlaces
     */
    public function getDecimalPlaces()
    {
        return $this->decimal_places;
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
}
