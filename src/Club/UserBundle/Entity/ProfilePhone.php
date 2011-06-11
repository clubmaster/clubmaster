<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\ProfilePhone")
 * @ORM\Table(name="club_user_profile_phone")
 */
class ProfilePhone
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
     * @var string $number
     */
    private $number;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $contact_type
     */
    private $contact_type;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $is_default
     */
    private $is_default;

    /**
     * @ORM\ManyToOne(targetEntity="Profile")
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
     * Set number
     *
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * Get number
     *
     * @return string $number
     */
    public function getNumber()
    {
        return $this->number;
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
