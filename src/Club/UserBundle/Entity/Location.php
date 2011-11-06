<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\Location")
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
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string $location_name
     */
    private $location_name;

    /**
     * @ORM\ManyToOne(targetEntity="Location")
     *
     * @var Club\UserBundle\Entity\Location
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity="Location", mappedBy="location")
     *
     * @var Club\UserBundle\Entity\Location
     */
    private $childs;


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
}
