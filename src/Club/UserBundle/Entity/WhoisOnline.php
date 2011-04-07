<?php

namespace Club\UserBundle\Entity;

/**
 * Club\UserBundle\Entity\WhoisOnline
 */
class WhoisOnline
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var Club\UserBundle\Entity\User
     */
    private $user;


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
}