<?php

namespace Club\UserBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\UserBundle\Repository\ProfileAddress")
 * @orm:Table(name="club_profile_address")
 */
class ProfileAddress
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
     * @assert:NotBlank()
     *
     * @var string $street
     */
    private $street;

    /**
     * @orm:Column(type="string", nullable="true")
     *
     * @var string $suburl
     */
    private $suburl;

    /**
     * @orm:Column(type="string")
     * @assert:NotBlank()
     *
     * @var string $postal_code
     */
    private $postal_code;

    /**
     * @orm:Column(type="string")
     * @assert:NotBlank()
     *
     * @var string $city
     */
    private $city;

    /**
     * @orm:Column(type="string", nullable="true")
     *
     * @var string $state
     */
    private $state;

    /**
     * @orm:Column(type="string")
     * @assert:NotBlank()
     *
     * @var string $country
     */
    private $country;

    /**
     * @orm:Column(type="string")
     * @assert:NotBlank()
     *
     * @var string $contact_type
     */
    private $contact_type;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $is_default
     */
    private $is_default;

    /**
     * @orm:ManyToOne(targetEntity="Profile")
     *
     * @var Club\UserBundle\Entity\Profile
     */
    private $profile;


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

    /**
     * Set profile
     *
     * @param Club\UserBundle\Entity\Profile $profile
     */
    public function setProfile(\Club\UserBundle\Entity\Profile $profile)
    {
        $this->profile = $profile;
    }

    /**
     * Get profile
     *
     * @return Club\UserBundle\Entity\Profile $profile
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
