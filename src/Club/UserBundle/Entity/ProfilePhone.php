<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Entity\ProfilePhoneRepository")
 * @ORM\Table(name="club_user_profile_phone")
 * @ORM\HasLifeCycleCallbacks()
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
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"user", "guest"})
     *
     * @var string $phone_number
     */
    protected $phone_number;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $contact_type
     */
    protected $contact_type;

    /**
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="profile_phones")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="cascade")
     *
     * @var Club\UserBundle\Entity\Profile
     */
    protected $profile;

    public function __construct()
    {
      $this->setContactType('home');
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
     * Set phone_number
     *
     * @param string $phone_number
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * Get phone_number
     *
     * @return string $phone_number
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
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
