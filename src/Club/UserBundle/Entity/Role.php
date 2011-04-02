<?php

namespace Club\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Club\UserBundle\Entity\Role
 */
class Role implements RoleInterface
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $role_name
     */
    private $role_name;


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

    /**
     * Implementation of getRole for the RoleInterface.
     * 
     * @return string The role.
     */
    public function getRole()
    {
      return $this->getRoleName();
    }
}
