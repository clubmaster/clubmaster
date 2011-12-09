<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Entity\LocationConfigRepository")
 * @ORM\Table(name="club_user_location_config",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="unique_idx", columns={"location_id","config"})}
 * )
 */
class LocationConfig
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
   * @ORM\Column(type="string")
   *
   * @var string $value
   */
  protected $value;

  /**
   * @ORM\Column(type="string")
   */
  protected $config;

  /**
   * @ORM\ManyToOne(targetEntity="Location")
   */
  protected $location;

  /**
   * Get id
   *
   * @return integer $id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Get value
   *
   * @return string $value
   */
  public function getValue()
  {
    return $this->value;
  }

  /**
   * Set value
   *
   * @param string $value
   */
  public function setValue($value)
  {
    $this->value = $value;
  }

  public function getLocation()
  {
    return $this->location;
  }

  public function setLocation($location)
  {
    $this->location = $location;
  }

  public function getConfig()
  {
    return $this->config;
  }

  public function setConfig($config)
  {
    $this->config = $config;
  }
}
