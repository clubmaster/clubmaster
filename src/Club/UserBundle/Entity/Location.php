<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Entity\LocationRepository")
 * @ORM\Table(name="club_user_location")
 */
class Location
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
     * @Assert\NotBlank()
     *
     * @var string $location_name
     */
    protected $location_name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var string $club
     */
    protected $club;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string $street
     */
    protected $street;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string $postal_code
     */
    protected $postal_code;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string $city
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string $state
     */
    protected $state;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string $country
     */
    protected $country;

    /**
     * @ORM\ManyToOne(targetEntity="Location")
     *
     * @var Club\UserBundle\Entity\Location
     */
    protected $location;

    /**
     * @ORM\OneToMany(targetEntity="Location", mappedBy="location")
     *
     * @var Club\UserBundle\Entity\Location
     */
    protected $childs;

    /**
     * @ORM\OneToMany(targetEntity="Club\BookingBundle\Entity\Field", mappedBy="location")
     */
    protected $fields;


    public function __toString()
    {
      return $this->getLocationName();
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
     * Set location_name
     *
     * @param string $locationName
     */
    public function setLocationName($locationName)
    {
        $this->location_name = $locationName;
    }

    /**
     * Get location_name
     *
     * @return string $locationName
     */
    public function getLocationName()
    {
        return $this->location_name;
    }

    /**
     * Set location
     *
     * @param Club\UserBundle\Entity\Location $location
     */
    public function setLocation(\Club\UserBundle\Entity\Location $location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return Club\UserBundle\Entity\Location $location
     */
    public function getLocation()
    {
        return $this->location;
    }
    public function __construct()
    {
        $this->childs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add childs
     *
     * @param Club\UserBundle\Entity\Location $childs
     */
    public function addLocation(\Club\UserBundle\Entity\Location $childs)
    {
        $this->childs[] = $childs;
    }

    /**
     * Get childs
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getChilds()
    {
        return $this->childs;
    }

    public function toArray()
    {
      return array(
        'id' => $this->getId(),
        'location_name' => $this->getLocationName(),
        'street' => $this->getStreet(),
        'postal_code' => $this->getPostalCode(),
        'city' => $this->getCity(),
        'state' => $this->getState(),
        'country' => $this->getCountry()
      );
    }

    /**
     * Add fields
     *
     * @param Club\BookingBundle\Entity\Field $fields
     */
    public function addField(\Club\BookingBundle\Entity\Field $fields)
    {
        $this->fields[] = $fields;
    }

    /**
     * Get fields
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set street
     *
     * @param text $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * Get street
     *
     * @return text
     */
    public function getStreet()
    {
        return $this->street;
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
     * @return string
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
     * @return string
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
     * @return string
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
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set club
     *
     * @param boolean $club
     */
    public function setClub($club)
    {
        $this->club = $club;
    }

    /**
     * Get club
     *
     * @return boolean
     */
    public function getClub()
    {
        return $this->club;
    }
}
