<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Entity\ResetPasswordRepository")
 * @ORM\Table(name="club_user_reset_password")
 * @ORM\HasLifeCycleCallbacks()
 */
class ResetPassword
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
     * @ORM\Column(type="datetime")
     *
     * @var string $expire_date
     */
    protected $expire_date;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $created_at
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     *
     * @var Club\UserBundle\Entity\User
     */
    protected $user;

    public function __construct()
    {
      $this->setExpireDate(new \DateTime());
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
     * Set expire_date
     *
     * @param datetime $expireDate
     */
    public function setExpireDate($expireDate)
    {
        $this->expire_date = $expireDate;
    }

    /**
     * Get expire_date
     *
     * @return datetime $expireDate
     */
    public function getExpireDate()
    {
        return $this->expire_date;
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
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
