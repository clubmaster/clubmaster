<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Entity\ProfileRepository")
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
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\NotBlank(groups={"user", "guest"})
     *
     * @var string $first_name
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\NotBlank(groups={"user", "guest"})
     *
     * @var string $last_name
     */
    protected $last_name;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank
     * @Assert\NotBlank(groups={"user"})
     *
     * var string $gender
     */
    protected $gender;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank()
     * @Assert\NotBlank(groups={"user"})
     */
    protected $day_of_birth;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="cascade")
     *
     * @var Club\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="ProfileAddress", cascade={"persist"})
     * @ORM\JoinColumn(name="profile_address_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $profile_address;

    /**
     * @ORM\ManyToOne(targetEntity="ProfilePhone", cascade={"persist"})
     * @ORM\JoinColumn(name="profile_phone_id", referencedColumnName="id")
     * @Assert\Valid
     */
    protected $profile_phone;

    /**
     * @ORM\ManyToOne(targetEntity="ProfileEmail", cascade={"persist"})
     * @ORM\JoinColumn(name="profile_email_id", referencedColumnName="id")
     */
    protected $profile_email;

    /**
     * @ORM\ManyToOne(targetEntity="ProfileCompany")
     */
    protected $profile_company;

    /**
     * @ORM\OneToMany(targetEntity="ProfileAddress", mappedBy="profile", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfileAddress
     */
    protected $profile_addresses;

    /**
     * @ORM\OneToMany(targetEntity="ProfilePhone", mappedBy="profile", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfilePhone
     */
    protected $profile_phones;

    /**
     * @ORM\OneToMany(targetEntity="ProfileEmail", mappedBy="profile", cascade={"persist"})
     * @Assert\Valid
     *
     * @var Club\UserBundle\Entity\ProfileEmail
     */
    protected $profile_emails;

    /**
     * @ORM\OneToMany(targetEntity="ProfileCompany", mappedBy="profile", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\ProfileCompany
     */
    protected $profile_companies;

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
     * Set profile_address
     *
     * @param Club\UserBundle\Entity\ProfileAddress $profileAddress
     */
    public function setProfileAddress(\Club\UserBundle\Entity\ProfileAddress $profileAddress=null)
    {
        $this->profile_address = $profileAddress;
    }

    /**
     * Get profile_address
     *
     * @return Club\UserBundle\Entity\ProfileAddress
     */
    public function getProfileAddress()
    {
        return $this->profile_address;
    }

    /**
     * Set profile_phone
     *
     * @param Club\UserBundle\Entity\ProfilePhone $profilePhone
     */
    public function setProfilePhone(\Club\UserBundle\Entity\ProfilePhone $profilePhone=null)
    {
        $this->profile_phone = $profilePhone;
    }

    /**
     * Get profile_phone
     *
     * @return Club\UserBundle\Entity\ProfilePhone
     */
    public function getProfilePhone()
    {
        return $this->profile_phone;
    }

    /**
     * Set profile_email
     *
     * @param Club\UserBundle\Entity\ProfileEmail $profileEmail
     */
    public function setProfileEmail(\Club\UserBundle\Entity\ProfileEmail $profileEmail=null)
    {
        $this->profile_email = $profileEmail;
    }

    /**
     * Get profile_email
     *
     * @return Club\UserBundle\Entity\ProfileEmail
     */
    public function getProfileEmail()
    {
        return $this->profile_email;
    }

    /**
     * Set profile_company
     *
     * @param Club\UserBundle\Entity\ProfileCompany $profileCompany
     */
    public function setProfileCompany(\Club\UserBundle\Entity\ProfileCompany $profileCompany)
    {
        $this->profile_company = $profileCompany;
    }

    /**
     * Get profile_company
     *
     * @return Club\UserBundle\Entity\ProfileCompany
     */
    public function getProfileCompany()
    {
        return $this->profile_company;
    }

    /**
     * Add profile_addresses
     *
     * @param Club\UserBundle\Entity\ProfileAddress $profileAddresses
     */
    public function addProfileAddresses(\Club\UserBundle\Entity\ProfileAddress $profileAddresses)
    {
        $this->profile_addresses[] = $profileAddresses;
    }

    /**
     * Get profile_addresses
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getProfileAddresses()
    {
        return $this->profile_addresses;
    }

    /**
     * Add profile_phones
     *
     * @param Club\UserBundle\Entity\ProfilePhone $profilePhones
     */
    public function addProfilePhones(\Club\UserBundle\Entity\ProfilePhone $profilePhones)
    {
        $this->profile_phones[] = $profilePhones;
    }

    /**
     * Get profile_phones
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getProfilePhones()
    {
        return $this->profile_phones;
    }

    /**
     * Set profile_emails
     *
     * @param Club\UserBundle\Entity\ProfileEmail $profileEmails
     */
    public function setProfileEmails($profileEmails)
    {
      foreach ($profileEmails as $email) {
        $email->setProfile($this);
      }

      $this->profile_emails = $profileEmails;
    }

    /**
     * Add profile_emails
     *
     * @param Club\UserBundle\Entity\ProfileEmail $profileEmails
     */
    public function addProfileEmails(\Club\UserBundle\Entity\ProfileEmail $profileEmails)
    {
        $this->profile_emails[] = $profileEmails;
    }

    /**
     * Get profile_emails
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getProfileEmails()
    {
        return $this->profile_emails;
    }

    /**
     * Add profile_companies
     *
     * @param Club\UserBundle\Entity\ProfileCompany $profileCompanies
     */
    public function addProfileCompanies(\Club\UserBundle\Entity\ProfileCompany $profileCompanies)
    {
        $this->profile_companies[] = $profileCompanies;
    }

    /**
     * Get profile_companies
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getProfileCompanies()
    {
        return $this->profile_companies;
    }

    public function getName()
    {
      return $this->getFirstName().' '.$this->getLastName();
    }

    public function getAge()
    {
      $ageTime = $this->getDayOfBirth()->getTimestamp();
      $t = time();
      $age = ($ageTime < 0) ? ( $t + ($ageTime * -1) ) : $t - $ageTime;
      $year = 60 * 60 * 24 * 365;
      $ageYears = $age / $year;

      return floor($ageYears);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->profile_addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profile_phones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profile_emails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->profile_companies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add profile_addresses
     *
     * @param Club\UserBundle\Entity\ProfileAddress $profileAddresses
     * @return Profile
     */
    public function addProfileAddresse(\Club\UserBundle\Entity\ProfileAddress $profileAddresses)
    {
        $this->profile_addresses[] = $profileAddresses;

        return $this;
    }

    /**
     * Remove profile_addresses
     *
     * @param Club\UserBundle\Entity\ProfileAddress $profileAddresses
     */
    public function removeProfileAddresse(\Club\UserBundle\Entity\ProfileAddress $profileAddresses)
    {
        $this->profile_addresses->removeElement($profileAddresses);
    }

    /**
     * Add profile_phones
     *
     * @param Club\UserBundle\Entity\ProfilePhone $profilePhones
     * @return Profile
     */
    public function addProfilePhone(\Club\UserBundle\Entity\ProfilePhone $profilePhones)
    {
        $this->profile_phones[] = $profilePhones;

        return $this;
    }

    /**
     * Remove profile_phones
     *
     * @param Club\UserBundle\Entity\ProfilePhone $profilePhones
     */
    public function removeProfilePhone(\Club\UserBundle\Entity\ProfilePhone $profilePhones)
    {
        $this->profile_phones->removeElement($profilePhones);
    }

    /**
     * Add profile_emails
     *
     * @param Club\UserBundle\Entity\ProfileEmail $profileEmails
     * @return Profile
     */
    public function addProfileEmail(\Club\UserBundle\Entity\ProfileEmail $profileEmails)
    {
        $this->profile_emails[] = $profileEmails;

        return $this;
    }

    /**
     * Remove profile_emails
     *
     * @param Club\UserBundle\Entity\ProfileEmail $profileEmails
     */
    public function removeProfileEmail(\Club\UserBundle\Entity\ProfileEmail $profileEmails)
    {
        $this->profile_emails->removeElement($profileEmails);
    }

    /**
     * Add profile_companies
     *
     * @param Club\UserBundle\Entity\ProfileCompany $profileCompanies
     * @return Profile
     */
    public function addProfileCompanie(\Club\UserBundle\Entity\ProfileCompany $profileCompanies)
    {
        $this->profile_companies[] = $profileCompanies;

        return $this;
    }

    /**
     * Remove profile_companies
     *
     * @param Club\UserBundle\Entity\ProfileCompany $profileCompanies
     */
    public function removeProfileCompanie(\Club\UserBundle\Entity\ProfileCompany $profileCompanies)
    {
        $this->profile_companies->removeElement($profileCompanies);
    }
}
