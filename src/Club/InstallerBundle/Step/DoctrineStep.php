<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Club\InstallerBundle\Step;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Doctrine Step.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DoctrineStep
{
    /**
     * @Assert\Choice(callback="getDriverKeys")
     */
    public $driver;

    /**
     * @Assert\NotBlank
     */
    public $host;

    /**
     * @Assert\Range(
     *   min = 0
     * )
     */
    public $port;

    /**
     * @Assert\NotBlank
     */
    public $name;

    /**
     * @Assert\NotBlank
     */
    public $user;

    public $password;

    public $secret;


    public function __construct()
    {
        $this->name = 'clubmaster';
        $this->host = 'localhost';
        $this->port = null;
        $this->user = 'root';
        $this->secret = hash('sha1', uniqid(mt_rand()));
    }

    /**
     * @return array
     */
    public static function getDriverKeys()
    {
        return array_keys(static::getDrivers());
    }

    /**
     * @return array
     */
    public static function getDrivers()
    {
        return array(
            'pdo_mysql'  => 'MySQL (PDO)'
        );
    }
}
