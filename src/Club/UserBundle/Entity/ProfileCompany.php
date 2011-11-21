<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Entity\ProfileCompanyRepository")
 * @ORM\Table(name="club_user_profile_company")
 */
class ProfileCompany
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
     *
     * @var string $company_name
     */
    private $company_name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $cvr
     */
    private $cvr;

    /**
     * @ORM\ManyToOne(targetEntity="Profile")
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
     * Set company_name
     *
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->company_name = $companyName;
    }

    /**
     * Get company_name
     *
     * @return string $companyName
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * Set cvr
     *
     * @param string $cvr
     */
    public function setCvr($cvr)
    {
        $this->cvr = $cvr;
    }

    /**
     * Get cvr
     *
     * @return string $cvr
     */
    public function getCvr()
    {
        return $this->cvr;
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
