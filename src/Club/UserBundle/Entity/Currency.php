<?php

namespace Club\UserBundle\Entity;

/**
 * Club\UserBundle\Entity\Currency
 */
class Currency
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $code
     */
    private $code;

    /**
     * @var string $symbol_left
     */
    private $symbol_left;

    /**
     * @var string $symbol_right
     */
    private $symbol_right;

    /**
     * @var string $decimal_places
     */
    private $decimal_places;

    /**
     * @var float $value
     */
    private $value;


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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
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