<?php

namespace Club\UserBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\UserBundle\Repository\Profile")
 * @orm:Table(name="club_profile")
 */
class Profile
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
     * @var string $first_name
     */
    private $first_name;

    /**
     * @orm:Column(type="string")
     * @assert:NotBlank()
     *
     * @var string $last_name
     */
    private $last_name;

    /**
     * @orm:Column(type="string")
     * @assert:NotBlank()
     *
     * var string $gender
     */
    private $gender;

    /**
     * @orm:OneToOne(targetEntity="User")
     *
     * @var Club\UserBundle\Entity\User
     */
    private $user;

    /**
     * @orm:OneToMany(targetEntity="ProfileAddress", mappedBy="profile_id", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfileAddress
     */
    private $profile_address;

    /**
     * @orm:OneToMany(targetEntity="ProfilePhone", mappedBy="profile_id", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfilePhone
     */
    private $profile_phone;

    /**
     * @orm:OneToMany(targetEntity="ProfileEmail", mappedBy="profile_id", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfileEmail
     */
    private $profile_email;

    /**
     * @orm:OneToMany(targetEntity="ProfileCompany", mappedBy="profile_id", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfileCompany
     */
    private $profile_company;

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

    public function getName()
    {
      return $this->getFirstName().' '.$this->getLastName();
    }

    public function getProfileAddress()
    {
      return $this->profile_address;
    }

    public function setProfileAddress($profile_address)
    {
      $this->profile_address[] = $profile_address;
    }

    public function getProfilePhone()
    {
      return $this->profile_phone;
    }

    public function setProfilePhone($profile_phone)
    {
      $this->profile_phone[] = $profile_phone;
    }

    public function getProfileEmail()
    {
      return $this->profile_email;
    }

    public function setProfileEmail($profile_email)
    {
      $this->profile_email[] = $profile_email;
    }

    public function getProfileCompany()
    {
      return $this->profile_company;
    }

    public function setProfileCompany($profile_company)
    {
      $this->profile_company[] = $profile_company;
    }
}
