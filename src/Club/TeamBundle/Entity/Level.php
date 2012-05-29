<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\TeamBundle\Entity\Level
 *
 * @ORM\Table(name="club_team_level")
 * @ORM\Entity(repositoryClass="Club\TeamBundle\Entity\LevelRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Level
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $level_name
     *
     * @ORM\Column(name="level_name", type="string", length=255)
     */
    protected $level_name;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updated_at;

    public function __toString()
    {
      return $this->getLevelName();
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
     * Set level_name
     *
     * @param string $levelName
     */
    public function setLevelName($levelName)
    {
        $this->level_name = $levelName;
    }

    /**
     * Get level_name
     *
     * @return string
     */
    public function getLevelName()
    {
        return $this->level_name;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
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
}
