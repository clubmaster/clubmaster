<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $company_name
     */
    protected $company_name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $vat
     */
    protected $vat;

    /**
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="profile_companies")
     * @var Club\UserBundle\Entity\Profile
     */
    protected $profile;

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
     * Set vat
     *
     * @param string $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * Get vat
     *
     * @return string $vat
     */
    public function getVat()
    {
        return $this->vat;
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
