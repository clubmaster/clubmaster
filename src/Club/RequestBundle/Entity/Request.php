<?php

namespace Club\RequestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\RequestBundle\Entity\Request
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Club\RequestBundle\Entity\RequestRepository")
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
}