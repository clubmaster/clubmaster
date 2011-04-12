<?php

namespace Club\UserBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\UserBundle\Repository\ProfileCompany")
 * @orm:Table(name="club_profile_company")
 */
class ProfileCompany
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
     *
     * @var string $company_name
     */
    private $company_name;

    /**
     * @orm:Column(type="string")
     *
     * @var string $cvr
     */
    private $cvr;

    /**
     * @orm:Column(type="boolean")
     *
     * @var boolean $is_default
     */
    private $is_default;

    /**
     * @orm:ManyToOne(targetEntity="Profile")
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
