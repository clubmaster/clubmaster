<?php

namespace Club\RequestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\RequestBundle\Entity\Request
 *
 * @ORM\Table(name="club_request_request")
 * @ORM\Entity(repositoryClass="Club\RequestBundle\Entity\RequestRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Request
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
     * @var datetime $play_time
     *
     * @ORM\Column(name="play_time", type="datetime")
     */
    private $play_time;

    /**
     * @var boolean $closed
     *
     * @ORM\Column(type="boolean")
     */
    private $closed;

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
     * @ORM\ManyToOne(targetEntity="Club\UserBundle\Entity\User")
     *
     * @var Club\UserBundle\Entity\User
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="RequestComment", mappedBy="request")
     *
     * @var Club\RequestBundle\Entity\RequestComment
     */
    protected $request_comments;


    public function __construct()
    {
      $this->setClosed(false);
      $this->setPlayTime(new \DateTime(date('Y-m-d 15:00:00')));
      $i = new \DateInterval('P1D');
      $this->getPlayTime()->add($i);
    }

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
     * Set play_time
     *
     * @param datetime $playTime
     */
    public function setPlayTime($playTime)
    {
        $this->play_time = $playTime;
    }

    /**
     * Get play_time
     *
     * @return datetime
     */
    public function getPlayTime()
    {
        return $this->play_time;
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

    /**
     * Add request_comments
     *
     * @param Club\RequestBundle\Entity\RequestComment $requestComments
     */
    public function addRequestComment(\Club\RequestBundle\Entity\RequestComment $requestComments)
    {
        $this->request_comments[] = $requestComments;
    }

    /**
     * Get request_comments
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getRequestComments()
    {
        return $this->request_comments;
    }

    /**
     * Set closed
     *
     * @param boolean $closed
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

    /**
     * Get closed
     *
     * @return boolean
     */
    public function getClosed()
    {
        return $this->closed;
    }
}
