<?php

namespace Club\UserBundle\Entity;

/**
 * Club\UserBundle\Entity\UserProfile
 */
class UserProfile
{
    /**
     * @var integer $id
     */
    private $id;


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
}