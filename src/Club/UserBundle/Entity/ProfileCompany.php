<?php

namespace Club\UserBundle\Entity;

/**
 * Club\UserBundle\Entity\ProfileCompany
 */
class ProfileCompany
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $profile_id
     */
    private $profile_id;

    /**
     * @var string $company_name
     */
    private $company_name;

    /**
     * @var string $cvr
     */
    private $cvr;

    /**
     * @var boolean $is_default
     */
    private $is_default;


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
     * Set profile_id
     *
     * @param integer $profileId
     */
    public function setProfileId($profileId)
    {
        $this->profile_id = $profileId;
    }

    /**
     * Get profile_id
     *
     * @return integer $profileId
     */
    public function getProfileId()
    {
        return $this->profile_id;
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
}