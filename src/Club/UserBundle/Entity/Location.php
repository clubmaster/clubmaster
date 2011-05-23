<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\Location")
 * @ORM\Table(name="club_location")
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
     * @ORM\ManyToMany(targetEntity="Group")
     *
     * @var Club\UserBundle\Entity\Group
     */
    private $groups;

    /**
     * @ORM\ManyToMany(targetEntity="Club\MailBundle\Entity\Mail")
     *
     * @var Club\MailBundle\Entity\Mail
     */
    private $mails;

    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mails = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
