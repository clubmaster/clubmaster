<?php

namespace Club\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\UserBundle\Repository\Config")
 * @ORM\Table(name="club_user_config")
 */
class Config
{
  /**
   * @ORM\Id
   * @ORM\Column(type="string", unique=true)
   *
   * @var string $config_key
   */
  private $config_key;


  /**
   * Get Config key
   *
   * @return string $config_key
   */
  public function getConfigKey()
  {
    return $this->config_key;
  }

  /**
   * Set Config key
   *
   * @param string $config_key
   */
  public function setConfigKey($config_key)
  {
    $this->config_key = $config_key;
  }
}
