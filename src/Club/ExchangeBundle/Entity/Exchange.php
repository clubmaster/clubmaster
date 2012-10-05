<?php

namespace Club\ExchangeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club\ExchangeBundle\Entity\Exchange
 *
 * @ORM\Table(name="club_exchange_exchange")
 * @ORM\Entity(repositoryClass="Club\ExchangeBundle\Entity\ExchangeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Exchange
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
     * @var string $message
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $message;

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
     * @ORM\OneToMany(targetEntity="ExchangeComment", mappedBy="exchange")
     *
     * @var Club\ExchangeBundle\Entity\ExchangeComment
     */
    protected $exchange_comments;

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
     * Add exchange_comments
     *
     * @param Club\ExchangeBundle\Entity\ExchangeComment $exchangeComments
     */
    public function addExchangeComment(\Club\ExchangeBundle\Entity\ExchangeComment $exchangeComments)
    {
        $this->exchange_comments[] = $exchangeComments;
    }

    /**
     * Get exchange_comments
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getExchangeComments()
    {
        return $this->exchange_comments;
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

    /**
     * Set message
     *
     * @param text $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return text
     */
    public function getMessage()
    {
        return $this->message;
    }
}
