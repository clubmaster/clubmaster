<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Entity\UserNoteRepository")
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
    protected $id;

    /**
     * @ORM\Column(type="text")
     *
     * @var string $note
     */
    protected $note;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var string $created_at
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @var Club\UserBundle\Entity\User
     */
    protected $user;

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
      $this->setCreatedAt(new \DateTime());
    }
}
