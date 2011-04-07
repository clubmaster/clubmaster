<?php

namespace Club\UserBundle\Entity;

/**
 * Club\UserBundle\Entity\Role
 */
class Role
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
     * @var Club\ShopBundle\Entity\ShopProduct
     */
    private $products;

    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add products
     *
     * @param Club\ShopBundle\Entity\ShopProduct $products
     */
    public function addProducts(\Club\ShopBundle\Entity\ShopProduct $products)
    {
        $this->products[] = $products;
    }

    /**
     * Get products
     *
     * @return Doctrine\Common\Collections\Collection $products
     */
    public function getProducts()
    {
        return $this->products;
    }
}