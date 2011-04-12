<?php

namespace Club\ShopBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\ShopBundle\Repository\Category")
 * @orm:Table(name="club_shop_category")
 */
class Category
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
     * @var string $name
     */
    private $name;

    /**
     * @orm:Column(type="string")
     *
     * @var text $description
     */
    private $description;

    /**
     * @orm:ManyToOne(targetEntity="Module")
     *
     * @var Club\ShopBundle\Entity\Module
     */
    private $module;

    /**
     * @orm:ManyToOne(targetEntity="Image")
     *
     * @var Club\ShopBundle\Entity\Image
     */
    private $image;

    /**
     * @orm:ManyToOne(targetEntity="Category")
     *
     * @var Club\ShopBundle\Entity\Category
     */
    private $category;

    /**
     * @var Club\ShopBundle\Entity\Product
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set module
     *
     * @param Club\ShopBundle\Entity\Module $Module
     */
    public function setModule(\Club\ShopBundle\Entity\Module $Module)
    {
        $this->module = $Module;
    }

    /**
     * Get module
     *
     * @return Club\ShopBundle\Entity\Module $Module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Add products
     *
     * @param Club\ShopBundle\Entity\Product $Product
     */
    public function addProduct(\Club\ShopBundle\Entity\Product $Product)
    {
        $this->products[] = $Product;
    }

    /**
     * Get products
     *
     * @return Doctrine\Common\Collections\Collection $Product
     */
    public function getProduct()
    {
        return $this->products;
    }
}
