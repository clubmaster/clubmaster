<?php

namespace Club\UserBundle\Entity;

/**
 * Club\UserBundle\Entity\ProfileEmail
 */
class ProfileEmail
{
    /**
     * @var integer $id
     */
    private $id;


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
     * @var integer $profile_id
     */
    private $profile_id;

    /**
     * @var string $email_address
     */
    private $email_address;

    /**
     * @var string $contact_type
     */
    private $contact_type;

    /**
     * @var boolean $is_default
     */
    private $is_default;


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
     * Set email_address
     *
     * @param string $emailAddress
     */
    public function setEmailAddress($emailAddress)
    {
        $this->email_address = $emailAddress;
    }

    /**
     * Get email_address
     *
     * @return string $emailAddress
     */
    public function getEmailAddress()
    {
        return $this->email_address;
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
}