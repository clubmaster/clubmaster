<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\UserBundle\Entity\Connection
 *
 * @ORM\Table(name="club_user_connection")
 * @ORM\Entity(repositoryClass="Club\UserBundle\Entity\ConnectionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Connection
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
     * @var string $type
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @var Club\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @var Club\UserBundle\Entity\User
     */
    protected $connection;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

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
     * Set type
     *
     * @param string $type
     * @return Connection
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Connection
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set user
     *
     * @param Club\UserBundle\Entity\User $user
     * @return Connection
     */
    public function setUser(\Club\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
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

    /**
     * Set connection
     *
     * @param Club\UserBundle\Entity\User $connection
     * @return Connection
     */
    public function setConnection(\Club\UserBundle\Entity\User $connection = null)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Get connection
     *
     * @return Club\UserBundle\Entity\User
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
    }
}

