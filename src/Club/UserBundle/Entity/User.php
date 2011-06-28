<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\User")
 * @ORM\Table(name="club_user_user")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(type="integer")
     *
     * @var integer $member_number
     */
    private $member_number;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $password
     */
    private $password;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     *
     * @var date $last_login_time
     */
    private $last_login_time;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $last_login_ip
     */
    private $last_login_ip;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $enabled
     */
    private $enabled;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $algorithm
     */
    private $algorithm;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $salt
     */
    private $salt;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $locked
     */
    private $locked;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $expired
     */
    private $expired;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var boolean $activated
     */
    private $activated;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     *
     * @var date $expires_at
     */
    private $expires_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var date $created_at
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var date $updated_at
     */
    private $updated_at;

    /**
     * @ORM\OneToOne(targetEntity="Profile", fetch="EAGER", cascade={"persist"})
     *
     * @var Club\UserBundle\Entity\Profile
     */
    private $profile;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     *
     * @var Club\UserBundle\Entity\Language
     */
    private $language;

    /**
     * @ORM\ManyToOne(targetEntity="Location")
     *
     * @var Club\UserBundle\Entity\Location
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="club_user_user_role",
     *   joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="Club\ShopBundle\Entity\Subscription", mappedBy="user")
     */
    private $subscriptions;

    /**
     * @ORM\OneToMany(targetEntity="Club\EventBundle\Entity\Attend", mappedBy="user")
     */
    private $attends;

    /**
     * @ORM\ManyToMany(targetEntity="Group", mappedBy="users")
     */
    private $groups;


    public function __toString()
    {
      return $this->getMemberNumber(). ' ('.$this->getProfile()->getName().')';
    }

    public function __construct()
    {
      $this->subscriptions = new \Doctrine\Common\Collections\ArrayCollection();
      $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
      $this->groups = new \Doctrine\Common\Collections\ArrayCollection();

      $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
      $this->algorithm = 'sha512';
      $this->enabled = false;
      $this->locked = false;
      $this->expired = false;
      $this->roles = array();
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
     * Set member_number
     *
     * @param string $member_number
     */
    public function setMemberNumber($member_number)
    {
        $this->member_number = $member_number;
    }

    /**
     * Get member_number
     *
     * @return string $member_number
     */
    public function getMemberNumber()
    {
        return $this->member_number;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
      $encoder = new MessageDigestPasswordEncoder($this->getAlgorithm(),true,10);
      $password = $encoder->encodePassword($password,$this->getSalt());

      $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set last_login_time
     *
     * @param date $lastLoginTime
     */
    public function setLastLoginTime($lastLoginTime)
    {
        $this->last_login_time = $lastLoginTime;
    }

    /**
     * Get last_login_time
     *
     * @return date $lastLoginTime
     */
    public function getLastLoginTime()
    {
        return $this->last_login_time;
    }

    /**
     * Set last_login_ip
     *
     * @param string $lastLoginIp
     */
    public function setLastLoginIp($lastLoginIp)
    {
        $this->last_login_ip = $lastLoginIp;
    }

    /**
     * Get last_login_ip
     *
     * @return string $lastLoginIp
     */
    public function getLastLoginIp()
    {
        return $this->last_login_ip;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set algorithm
     *
     * @param string $algorithm
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Get algorithm
     *
     * @return string $algorithm
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Get salt
     *
     * @return string $salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }

    /**
     * Get locked
     *
     * @return boolean $locked
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
    }

    /**
     * Get expired
     *
     * @return boolean $expired
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set expires_at
     *
     * @param date $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expires_at = $expiresAt;
    }

    /**
     * Get expires_at
     *
     * @return date $expiresAt
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
    }

    /**
     * Set created_at
     *
     * @param date $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param date $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
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

    /**
     * Set language
     *
     * @param Club\UserBundle\Entity\Language $language
     */
    public function setLanguage(\Club\UserBundle\Entity\Language $language)
    {
        $this->language = $language;
    }

    /**
     * Get language
     *
     * @return Club\UserBundle\Entity\Language $language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function getSubscriptions()
    {
      return $this->subscriptions;
    }

    public function getGroups()
    {
      return $this->groups;
    }

    /**
     * @ORM\prePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\preUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    public function toArray()
    {
      return array(
        'id' => $this->getId(),
        'member_number' => $this->getMemberNumber(),
        'created_at' => $this->getCreatedAt(),
        'updated_at' => $this->getUpdatedAt(),
        'profile' => array(
          'first_name' => $this->getProfile()->getFirstName(),
          'last_name' => $this->getProfile()->getLastName(),
          'gender' => $this->getProfile()->getGender()
        )
      );
    }

    public function addRole($role)
    {
      $this->roles[] = $role;
    }

    public function getUserRoles()
    {
      return $this->roles;
    }

    public function getRoles()
    {
      $roles = $this->roles->toArray();

      foreach ($this->getGroups() as $group) {
        $roles = array_merge($roles, $group->getRole()->toArray());
      }

      $roles[] = 'ROLE_USER';

      return array_unique($roles);
    }

    public function eraseCredentials()
    {
    }

    public function equals(UserInterface $user)
    {
      return md5($this->getMemberNumber()) == md5($user->getMemberNumber());
    }

    public function getUsername()
    {
      return $this->getMemberNumber();
    }

    public function serialize()
    {
      return serialize(array($this->getMemberNumber()));
    }

    public function unserialize($serialized)
    {
      $data = unserialize($serialized);
      $this->setMemberNumber($data[0]);
    }

    /**
     * Set location
     *
     * @param Club\UserBundle\Entity\Location $location
     */
    public function setLocation(\Club\UserBundle\Entity\Location $location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return Club\UserBundle\Entity\Location $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add roles
     *
     * @param Club\UserBundle\Entity\Role $roles
     */
    public function addRoles(\Club\UserBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;
    }

    /**
     * Add subscriptions
     *
     * @param Club\ShopBundle\Entity\Subscription $subscriptions
     */
    public function addSubscriptions(\Club\ShopBundle\Entity\Subscription $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;
    }

    /**
     * Add groups
     *
     * @param Club\UserBundle\Entity\Group $groups
     */
    public function setGroups($groups)
    {
        $this->groups[] = $groups;
    }

    public function inGroup(\Club\UserBundle\Entity\Group $group)
    {
      foreach ($this->getGroups() as $g) {
        if ($group->getId() === $g->getId()) return true;
      }

      return false;
    }

    /**
     * Add attends
     *
     * @param Club\EventBundle\Entity\Attend $attends
     */
    public function addAttends(\Club\EventBundle\Entity\Attend $attends)
    {
        $this->attends[] = $attends;
    }

    /**
     * Get attends
     *
     * @return Doctrine\Common\Collections\Collection $attends
     */
    public function getAttends()
    {
        return $this->attends;
    }

    /**
     * Add groups
     *
     * @param Club\UserBundle\Entity\Group $groups
     */
    public function addGroups(\Club\UserBundle\Entity\Group $groups)
    {
      $this->groups[] = $groups;
    }

    public function getActivationHash()
    {
      return hash('sha256',$this->getId().'-'.$this->getCreatedAt()->format('Y-m-d'));
    }

    /**
     * Set activated
     *
     * @param boolean $activated
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;
    }

    /**
     * Get activated
     *
     * @return boolean $activated
     */
    public function getActivated()
    {
        return $this->activated;
    }
}
