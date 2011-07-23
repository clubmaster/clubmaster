<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\UserNote")
 * @ORM\Table(name="club_user_user_note")
 * @ORM\HasLifecycleCallbacks()
 */
class UserNote
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
     * @ORM\Column(type="text")
     *
     * @var string $note
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $created_at
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="User")
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

    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getNote()
    {
      return $this->note;
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

    public function setCreatedAt($created_at)
    {
      $this->created_at = $created_at;
    }

    public function getCreatedAt()
    {
      return $this->created_at;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      if (!$this->getId())
        $this->setCreatedAt(new \DateTime());
    }
}
