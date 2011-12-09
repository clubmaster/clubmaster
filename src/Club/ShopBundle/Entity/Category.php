<?php

namespace Club\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\ShopBundle\Entity\CategoryRepository")
 * @ORM\Table(name="club_shop_category")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string $category_name
     */
    protected $category_name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var text $description
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Image")
     *
     * @var Club\ShopBundle\Entity\Image
     */
    protected $image;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     *
     * @var Club\ShopBundle\Entity\Category
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\Location")
     *
     * @var Club\UserBundle\Entity\Location
     */
    protected $location;

    /**
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="categories")
     *
     * @var Club\ShopBundle\Entity\Product
     */
    protected $products;

    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
      return $this->getCategoryName();
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

    /**
     * Set category
     *
     * @param string $categor
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return string $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set location
     *
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Get location
     *
     * @return string $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set image
     *
     * @param Club\ShopBundle\Entity\Image $image
     */
    public function setImage(\Club\ShopBundle\Entity\Image $image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return Club\ShopBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add products
     *
     * @param Club\ShopBundle\Entity\Product $products
     */
    public function addProducts(\Club\ShopBundle\Entity\Product $products)
    {
        $this->products[] = $products;
    }
}
