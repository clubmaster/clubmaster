<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\Filter")
 * @ORM\Table(name="club_user_filter")
 */
class Filter
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
     * @var string $filter_name
     */
    private $filter_name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="FilterAttribute", mappedBy="filter", cascade={"persist"})
     */
    private $attributes;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $user;


    public function __toString()
    {
      return $this->getFilterName();
    }

    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set filter_name
     *
     * @param string $filterName
     */
    public function setFilterName($filterName)
    {
        $this->filter_name = $filterName;
    }

    /**
     * Get filter_name
     *
     * @return string $filterName
     */
    public function getFilterName()
    {
        return $this->filter_name;
    }

    /**
     * Add attributes
     *
     * @param Club\UserBundle\Entity\FilterAttribute $attributes
     */
    public function addAttributes(\Club\UserBundle\Entity\FilterAttribute $attributes)
    {
        $this->attributes[] = $attributes;
    }

    /**
     * Get attributes
     *
     * @return Doctrine\Common\Collections\Collection $attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     */
    public function setUser(\Club\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Club\UserBundle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean $active
     */
    public function getActive()
    {
        return $this->active;
    }
}
