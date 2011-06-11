<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\Role")
 * @ORM\Table(name="club_user_role")
 */
class Role implements RoleInterface
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
     * @var string $role_name
     */
    private $role_name;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="roles")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Group")
     */
    private $groups;


    public function __toString()
    {
      return $this->getRoleName();
    }

    public function __construct()
    {
      $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set role_name
     *
     * @param string $roleName
     */
    public function setRoleName($roleName)
    {
        $this->role_name = $roleName;
    }

    /**
     * Get role_name
     *
     * @return string $roleName
     */
    public function getRoleName()
    {
        return $this->role_name;
    }

    public function getRole()
    {
      return $this->getRoleName();
    }

    public function getUsers()
    {
      return $this->users;
    }

    public function addUser($user)
    {
      $this->users[] = $user;
    }
}
