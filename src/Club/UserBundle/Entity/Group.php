<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\Group")
 * @ORM\Table(name="club_user_group")
 * @ORM\HasLifecycleCallbacks()
 */
class Group
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
     * @Assert\NotBlank()
     *
     * @var string $group_name
     */
    private $group_name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $group_type
     */
    private $group_type;

    /**
     * @ORM\Column(type="string", nullable="true")
     *
     * @var string $gender
     */
    private $gender;

    /**
     * @ORM\Column(type="integer", nullable="true")
     *
     * @var integer $min_age
     */
    private $min_age;

    /**
     * @ORM\Column(type="integer", nullable="true")
     *
     * @var integer $max_age
     */
    private $max_age;

    /**
     * @ORM\Column(type="boolean", nullable="true")
     *
     * @var boolean $active_member
     */
    private $active_member;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="Group")
     *
     * @var Club\UserBundle\Entity\Group
     */
    private $group;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="club_user_group_role",
     *   joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     * @var Club\UserBundle\Entity\Role
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="Location")
     * @ORM\JoinTable(name="club_user_group_location",
     *   joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="location_id", referencedColumnName="id")}
     * )
     *
     * @var Club\UserBundle\Entity\Location
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity="Club\ShopBundle\Entity\Product")
     *
     * @var Club\ShopBundle\Entity\Product
     */
    private $product;


    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="groups")
     * @ORM\JoinTable(name="club_user_user_group",
     *  joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $users;

    public function __construct()
    {
        $this->role = new \Doctrine\Common\Collections\ArrayCollection();
        $this->location = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
      return $this->getGroupName();
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
     * Set group_name
     *
     * @param string $groupName
     */
    public function setGroupName($groupName)
    {
        $this->group_name = $groupName;
    }

    /**
     * Get group_name
     *
     * @return string $groupName
     */
    public function getGroupName()
    {
        return $this->group_name;
    }

    /**
     * Set group_type
     *
     * @param string $groupType
     */
    public function setGroupType($groupType)
    {
        $this->group_type = $groupType;
    }

    /**
     * Get group_type
     *
     * @return string $groupType
     */
    public function getGroupType()
    {
        return $this->group_type;
    }

    /**
     * Set gender
     *
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Get gender
     *
     * @return string $gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set min_age
     *
     * @param integer $minAge
     */
    public function setMinAge($minAge)
    {
        $this->min_age = $minAge;
    }

    /**
     * Get min_age
     *
     * @return integer $minAge
     */
    public function getMinAge()
    {
        return $this->min_age;
    }

    /**
     * Set max_age
     *
     * @param integer $maxAge
     */
    public function setMaxAge($maxAge)
    {
        $this->max_age = $maxAge;
    }

    /**
     * Get max_age
     *
     * @return integer $maxAge
     */
    public function getMaxAge()
    {
        return $this->max_age;
    }

    /**
     * Set active_member
     *
     * @param boolean $activeMember
     */
    public function setActiveMember($activeMember)
    {
        $this->active_member = $activeMember;
    }

    /**
     * Get active_member
     *
     * @return boolean $activeMember
     */
    public function getActiveMember()
    {
        return $this->active_member;
    }

    /**
     * Set group
     *
     * @param Club\UserBundle\Entity\Group $group
     */
    public function setGroup(\Club\UserBundle\Entity\Group $group)
    {
        $this->group = $group;
    }

    /**
     * Get group
     *
     * @return Club\UserBundle\Entity\Group $group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Add role
     *
     * @param Club\UserBundle\Entity\Role $role
     */
    public function addRole(\Club\UserBundle\Entity\Role $role)
    {
        $this->role[] = $role;
    }

    /**
     * Get role
     *
     * @return Doctrine\Common\Collections\Collection $role
     */
    public function getRole()
    {
        return $this->role;
    }

    public function getUsers()
    {
      return $this->users;
    }

    public function setProduct($location)
    {
      $this->product[] = $product;
    }

    public function getProduct()
    {
      return $this->product;
    }

    /**
     * Add location
     *
     * @param Club\UserBundle\Entity\Location $location
     */
    public function addLocation(\Club\UserBundle\Entity\Location $location)
    {
        $this->location[] = $location;
    }

    /**
     * Get location
     *
     * @return Doctrine\Common\Collections\Collection $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add product
     *
     * @param Club\ShopBundle\Entity\Product $product
     */
    public function addProduct(\Club\ShopBundle\Entity\Product $product)
    {
        $this->product[] = $product;
    }

    /**
     * Add users
     *
     * @param Club\UserBundle\Entity\User $users
     */
    public function addUsers(\Club\UserBundle\Entity\User $users)
    {
      if (!$this->hasUser($users))
        $this->users[] = $users;
    }

    public function hasUser(\Club\UserBundle\Entity\User $user)
    {
      foreach ($this->getUsers() as $u) {
        if ($u == $user) return true;
      }

      return false;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      if (!$this->getId())
        $this->setCreatedAt(new \DateTime());

      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
