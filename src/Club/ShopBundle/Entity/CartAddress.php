<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Repository\CartAddress")
 * @ORM\Table(name="club_shop_cart_address")
 */
class CartAddress
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
     * @var string $company_name
     *
     * @ORM\Column(type="string", nullable="true")
     */
    private $company_name;

    /**
     * @var string $cvr
     *
     * @ORM\Column(type="string", nullable="true")
     */
    private $cvr;

    /**
     * @var string $first_name
     *
     * @ORM\Column(type="string")
     */
    private $first_name;

    /**
     * @var string $last_name
     *
     * @ORM\Column(type="string")
     */
    private $last_name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     *
     * @var string $street
     */
    private $street;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $suburl
     */
    private $suburl;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     *
     * @var string $postal_code
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     *
     * @var string $city
     */
    private $city;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $state
     */
    private $state;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     *
     * @var string $country
     */
    private $country;

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
     * Set companyName
     *
     * @param string $company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }

    /**
     * Get companyName
     *
     * @return string $comapny_name
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * Set cvr
     *
     * @param string $cvr
     */
    public function setCvr($cvr)
    {
        $this->cvr = $cvr;
    }

    /**
     * Get cvr
     *
     * @return string $cvr
     */
    public function getCvr()
    {
        return $this->cvr;
    }

    /**
     * Set firstName
     *
     * @param string $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * Get firstName
     *
     * @return string $first_name
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set lastName
     *
     * @param string $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * Get lastName
     *
     * @return string $last_name
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set street
     *
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Get street
     *
     * @return string $street
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set suburl
     *
     * @param string $suburl
     */
    public function setSuburl($suburl)
    {
        $this->suburl = $suburl;
    }

    /**
     * Get suburl
     *
     * @return string $suburl
     */
    public function getSuburl()
    {
        return $this->suburl;
    }

    /**
     * Set postal_code
     *
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postal_code = $postalCode;
    }

    /**
     * Get postal_code
     *
     * @return string $postalCode
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * Set city
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Get city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Get state
     *
     * @return string $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * Get country
     *
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set contact_type
     *
     * @param string $contactType
     */
    public function setContactType($contactType)
    {
        $this->contact_type = $contactType;
    }

    /**
     * Get contact_type
     *
     * @return string $contactType
     */
    public function getContactType()
    {
        return $this->contact_type;
    }

    /**
     * Set is_default
     *
     * @param boolean $isDefault
     */
    public function setIsDefault($isDefault)
    {
        $this->is_default = $isDefault;
    }

    /**
     * Get is_default
     *
     * @return boolean $isDefault
     */
    public function getIsDefault()
    {
        return $this->is_default;
    }
}
