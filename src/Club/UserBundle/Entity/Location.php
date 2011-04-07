<?php

namespace Club\UserBundle\Entity;

/**
 * Club\UserBundle\Entity\Location
 */
class Location
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $location_name
     */
    private $location_name;

    /**
     * @var Club\UserBundle\Entity\Location
     */
    private $location;

    /**
     * @var Club\UserBundle\Entity\Group
     */
    private $groups;

    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add groups
     *
     * @param Club\UserBundle\Entity\Group $groups
     */
    public function addGroups(\Club\UserBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    }

    /**
     * Get groups
     *
     * @return Doctrine\Common\Collections\Collection $groups
     */
    public function getGroups()
    {
        return $this->groups;
    }
}