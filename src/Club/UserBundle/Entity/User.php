<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\User")
 * @ORM\Table(name="club_user_user")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements AdvancedUserInterface, \Serializable
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
     * @ORM\Column(type="string", nullable="true")
     *
     * @var boolean $activation_code
     */
    private $activation_code;

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
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="cascade")
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

    /**
     * @ORM\ManyToMany(targetEntity="Club\TeamBundle\Entity\Schedule", mappedBy="users")
     */
    private $schedules;


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
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setActivationCode(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
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
      $res = array(
        'id' => $this->getId(),
        'member_number' => $this->getMemberNumber(),
        'first_name' => $this->getProfile()->getFirstName(),
        'last_name' => $this->getProfile()->getLastName(),
        'gender' => $this->getProfile()->getGender(),
        'day_of_birth' => $this->getProfile()->getDayOfBirth(),
        'member_status' => $this->getMemberStatus(),
        'created_at' => $this->getCreatedAt(),
        'updated_at' => $this->getUpdatedAt()
      );

      if ($this->getProfile()->getProfileAddress()) {
        $res['street'] = $this->getProfile()->getProfileAddress()->getStreet();
        $res['postal_code'] = $this->getProfile()->getProfileAddress()->getPostalCode();
        $res['city'] = $this->getProfile()->getProfileAddress()->getCity();
        $res['state'] = $this->getProfile()->getProfileAddress()->getState();
        $res['country'] = $this->getProfile()->getProfileAddress()->getCountry()->getCountry();
      }

      if ($this->getProfile()->getProfilePhone()) {
        $res['phone_number'] = $this->getProfile()->getProfilePhone()->getPhoneNumber();
      }

      if ($this->getProfile()->getProfileEmail()) {
        $res['email_address'] = $this->getProfile()->getProfileEmail()->getEmailAddress();
      }

      $res['subscriptions'] = array();
      foreach ($this->getSubscriptions() as $sub) {
        $res['subscriptions'][] = array(
          'id' => $sub->getId(),
          'type' => $sub->getType(),
          'start_date' => $sub->getStartDate(),
          'expire_date' => $sub->getExpireDate()
        );
      }

      $res['groups'] = array();
      foreach ($this->getGroups() as $group) {
        $res['groups'][] = array(
          'id' => $group->getId(),
          'group_name' => $group->getGroupName()
        );
      }

      return $res;
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

    public function equals(UserInterface $user)
    {
      if (!$user instanceof User) {
        return false;
      }

      if ($this->password !== $user->getPassword()) {
        return false;
      }
      if ($this->getSalt() !== $user->getSalt()) {
        return false;
      }
      if ($this->isAccountNonExpired() !== $user->isAccountNonExpired()) {
        return false;
      }
      if (!$this->locked !== $user->isAccountNonLocked()) {
        return false;
      }
      if ($this->isCredentialsNonExpired() !== $user->isCredentialsNonExpired()) {
        return false;
      }
      if ($this->enabled !== $user->isEnabled()) {
        return false;
      }

      return true;

    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
      return true;
    }

    public function isAccountNonLocked()
    {
      if ($this->getLocked() == 1)
        return false;

      return true;
    }

    public function isCredentialsNonExpired()
    {
      return true;
    }

    public function isEnabled()
    {
      return true;
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
     * Set activation_code
     *
     * @param string $activationCode
     */
    public function setActivationCode($activationCode)
    {
        $this->activation_code = $activationCode;
    }

    /**
     * Get activation_code
     *
     * @return string $activationCode
     */
    public function getActivationCode()
    {
        return $this->activation_code;
    }

    public function getMemberStatus()
    {
      foreach ($this->getSubscriptions() as $s) {
        if ($s->getStartDate()->getTimestamp() <= time()) {
          if ($s->getExpireDate()->getTimestamp() >= time() || $s->getExpireDate() == '') {
            if ($s->getActive())
              return true;
          }
        }
      }

      return false;
    }

    /**
     * Add subscriptions
     *
     * @param Club\ShopBundle\Entity\Subscription $subscriptions
     */
    public function addSubscription(\Club\ShopBundle\Entity\Subscription $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;
    }

    /**
     * Add attends
     *
     * @param Club\EventBundle\Entity\Attend $attends
     */
    public function addAttend(\Club\EventBundle\Entity\Attend $attends)
    {
        $this->attends[] = $attends;
    }

    /**
     * Add groups
     *
     * @param Club\UserBundle\Entity\Group $groups
     */
    public function addGroup(\Club\UserBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    }

    /**
     * Add schedules
     *
     * @param Club\TeamBundle\Entity\Schedule $schedules
     */
    public function addSchedule(\Club\TeamBundle\Entity\Schedule $schedules)
    {
        $this->schedules[] = $schedules;
    }

    /**
     * Get schedules
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getSchedules()
    {
        return $this->schedules;
    }

    public function isAttend(\Club\TeamBundle\Entity\Schedule $schedule)
    {
      foreach ($this->getSchedules() as $sch) {
        if ($schedule->getId() == $sch->getId())
          return true;
      }

      return false;
    }
}
