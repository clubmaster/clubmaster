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
     * @var string $category_name
     */
    private $category_name;

    /**
     * @orm:Column(type="string")
     *
     * @var text $description
     */
    private $description;

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
     * @orm:ManyToMany(targetEntity="Product", mappedBy="categories")
     *
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
     * Set categoryName
     *
     * @param string $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->category_name = $categoryName;
    }

    /**
     * Get categoryName
     *
     * @return string $categoryName
     */
    public function getCategoryName()
    {
        return $this->category_name;
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
    public function getProducts()
    {
        return $this->products;
    }
}
