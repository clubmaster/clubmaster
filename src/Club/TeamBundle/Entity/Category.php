<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\TeamBundle\Entity\Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Club\TeamBundle\Entity\CategoryRepository")
 */
class Category
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $category_name
     *
     * @ORM\Column(name="category_name", type="string", length=255)
     */
    private $category_name;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set category_name
     *
     * @param string $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->category_name = $categoryName;
    }

    /**
     * Get category_name
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->category_name;
    }
}
