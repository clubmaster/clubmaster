<?php

namespace Club\TeamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club\TeamBundle\Entity\Level
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Club\TeamBundle\Entity\LevelRepository")
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
    private $id;

    /**
     * @var string $level_name
     *
     * @ORM\Column(name="level_name", type="string", length=255)
     */
    private $level_name;


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
}