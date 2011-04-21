<?php

namespace Club\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * @orm:Entity(repositoryClass="Club\UserBundle\Repository\Role")
 * @orm:Table(name="club_role")
 */
class Role implements RoleInterface
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
     * @var string $role_name
     */
    private $role_name;

    /**
     * @orm:ManyToMany(targetEntity="User")
     */
    private $users;

    /**
     * @orm:ManyToMany(targetEntity="Group")
     */
    private $groups;

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
}
