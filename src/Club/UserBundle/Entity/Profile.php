<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\Profile")
 * @ORM\Table(name="club_user_profile")
 */
class Profile
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
     * @Assert\NotBlank
     *
     * @var string $first_name
     */
    private $first_name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     *
     * @var string $last_name
     */
    private $last_name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     *
     * var string $gender
     */
    private $gender;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $day_of_birth;

    /**
     * @ORM\OneToOne(targetEntity="User")
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="ProfileAddress", mappedBy="profile", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfileAddress
     */
    private $profile_address;

    /**
     * @ORM\OneToMany(targetEntity="ProfilePhone", mappedBy="profile", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfilePhone
     */
    private $profile_phone;

    /**
     * @ORM\OneToMany(targetEntity="ProfileEmail", mappedBy="profile", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfileEmail
     */
    private $profile_email;

    /**
     * @ORM\OneToMany(targetEntity="ProfileCompany", mappedBy="profile", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfileCompany
     */
    private $profile_company;


    public function __construct()
    {
      $this->profile_address = new \Doctrine\Common\Collections\ArrayCollection();
      $this->profile_email = new \Doctrine\Common\Collections\ArrayCollection();
      $this->profile_phone = new \Doctrine\Common\Collections\ArrayCollection();
      $this->profile_company = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set first_name
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }

    /**
     * Get first_name
     *
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getGender()
    {
      return $this->gender;
    }

    public function setGender($gender)
    {
      $this->gender = $gender;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }

    /**
     * Get last_name
     *
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     */
    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Club\UserBundle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add profile_address
     *
     * @param Club\UserBundle\Entity\ProfileAddress $profileAddress
     */
    public function addProfileAddress(\Club\UserBundle\Entity\ProfileAddress $profileAddress)
    {
        $this->profile_address[] = $profileAddress;
    }

    /**
     * Get profile_address
     *
     * @return Doctrine\Common\Collections\Collection $profileAddress
     */
    public function getProfileAddress()
    {
        return $this->profile_address;
    }

    /**
     * Add profile_phone
     *
     * @param Club\UserBundle\Entity\ProfilePhone $profilePhone
     */
    public function addProfilePhone(\Club\UserBundle\Entity\ProfilePhone $profilePhone)
    {
        $this->profile_phone[] = $profilePhone;
    }

    /**
     * Add profile_email
     *
     * @param Club\UserBundle\Entity\ProfileEmail $profileEmail
     */
    public function addProfileEmail(\Club\UserBundle\Entity\ProfileEmail $profileEmail)
    {
        $this->profile_email[] = $profileEmail;
    }

    /**
     * Add profile_company
     *
     * @param Club\UserBundle\Entity\ProfileCompany $profileCompany
     */
    public function addProfileCompany(\Club\UserBundle\Entity\ProfileCompany $profileCompany)
    {
        $this->profile_company[] = $profileCompany;
    }

    /**
     * Set day_of_birth
     *
     * @param date $dayOfBirth
     */
    public function setDayOfBirth($dayOfBirth)
    {
        $this->day_of_birth = $dayOfBirth;
    }

    /**
     * Get day_of_birth
     *
     * @return date $dayOfBirth
     */
    public function getDayOfBirth()
    {
        return $this->day_of_birth;
    }

    /**
     * Get profile_phone
     *
     * @return Doctrine\Common\Collections\Collection $profilePhone
     */
    public function getProfilePhone()
    {
        return $this->profile_phone;
    }

    /**
     * Get profile_email
     *
     * @return Doctrine\Common\Collections\Collection $profileEmail
     */
    public function getProfileEmail()
    {
        return $this->profile_email;
    }

    /**
     * Get profile_company
     *
     * @return Doctrine\Common\Collections\Collection $profileCompany
     */
    public function getProfileCompany()
    {
        return $this->profile_company;
    }

    public function getName()
    {
      return $this->getFirstName().' '.$this->getLastName();
    }

    public function setProfilePhone($profile_phone)
    {
      $this->profile_phone = $profile_phone;
    }
}
