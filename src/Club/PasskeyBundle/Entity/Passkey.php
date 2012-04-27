<?php

namespace Club\PasskeyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\PasskeyBundle\Entity\Passkey
 *
 * @ORM\Table(name="club_passkey_passkey")
 * @ORM\Entity(repositoryClass="Club\PasskeyBundle\Entity\PasskeyRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Passkey
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
     * @var string $key_identity
     *
     * @ORM\Column(name="key_identity", type="string", length=255)
     */
    private $key_identity;

    /**
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     * @var Club\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;


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
     * Set key_identity
     *
     * @param string $keyIdentity
     */
    public function setKeyIdentity($keyIdentity)
    {
        $this->key_identity = $keyIdentity;
    }

    /**
     * Get key_identity
     *
     * @return string
     */
    public function getKeyIdentity()
    {
        return $this->key_identity;
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

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\preUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
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
     * @return Club\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}