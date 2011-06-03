<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\Group")
 * @ORM\Table(name="club_group")
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
     * @ORM\Column(type="boolean")
     *
     * @var boolean $is_active_member
     */
    private $is_active_member;

    /**
     * @ORM\ManyToOne(targetEntity="Group")
     *
     * @var Club\UserBundle\Entity\Group
     */
    private $group;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     *
     * @var Club\UserBundle\Entity\Role
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="Club\ShopBundle\Entity\Product")
     *
     * @var Club\ShopBundle\Entity\Product
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="groups")
     *
     * @var Club\UserBundle\Entity\User
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
     * Set is_active_member
     *
     * @param boolean $isActiveMember
     */
    public function setIsActiveMember($isActiveMember)
    {
        $this->is_active_member = $isActiveMember;
    }

    /**
     * Get is_active_member
     *
     * @return boolean $isActiveMember
     */
    public function getIsActiveMember()
    {
        return $this->is_active_member;
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

    public function setUsers($users)
    {
      $this->users = $users;
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

}
