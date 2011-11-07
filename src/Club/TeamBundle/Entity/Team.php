<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\TeamBundle\Entity\Team
 *
 * @ORM\Table(name="club_team_team")
 * @ORM\Entity(repositoryClass="Club\TeamBundle\Entity\TeamRepository")
 */
class Team
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
     * @var string $team_name
     *
     * @ORM\Column(name="team_name", type="string", length="255")
     */
    private $team_name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * @ORM\ManyToOne(targetEntity="Level")
     */
    private $level;

    /**
     * @ORM\ManyToMany(targetEntity="ClubUserBundle:User")
     * @ORM\JoinTable(name="club_team_team_user")
     */
    private $instructors;


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
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
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
     * Set team_name
     *
     * @param string $teamName
     */
    public function setTeamName($teamName)
    {
        $this->team_name = $teamName;
    }

    /**
     * Get team_name
     *
     * @return string
     */
    public function getTeamName()
    {
        return $this->team_name;
    }

    /**
     * Set level
     *
     * @param Club\TeamBundle\Entity\Level $level
     */
    public function setLevel(\Club\TeamBundle\Entity\Level $level)
    {
        $this->level = $level;
    }

    /**
     * Get level
     *
     * @return Club\TeamBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }
    public function __construct()
    {
        $this->instructors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add instructors
     *
     * @param Club\TeamBundle\Entity\ClubUserBundle:User $instructors
     */
    public function addClubUserBundle:User(\Club\TeamBundle\Entity\ClubUserBundle:User $instructors)
    {
        $this->instructors[] = $instructors;
    }

    /**
     * Get instructors
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getInstructors()
    {
        return $this->instructors;
    }
}
