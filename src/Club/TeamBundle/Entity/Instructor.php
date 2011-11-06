<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\TeamBundle\Entity\Instructor
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Club\TeamBundle\Entity\InstructorRepository")
 */
class Instructor
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
     * @var integer $team
     *
     * @ORM\Column(name="team", type="integer")
     */
    private $team;

    /**
     * @var integer $user
     *
     * @ORM\Column(name="user", type="integer")
     */
    private $user;


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
     * Set team
     *
     * @param integer $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * Get team
     *
     * @return integer 
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set user
     *
     * @param integer $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }
}