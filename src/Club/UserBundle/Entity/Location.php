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
        'location_name' => $this->getLocationName()
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
}
