<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Club\ConfiguratorBundle\Configurator\Step;

use Club\ConfiguratorBundle\Configurator\Form\DoctrineStepType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Doctrine Step.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DoctrineStep implements StepInterface
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
     * @Assert\Min(0)
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

    public function __construct(array $parameters)
    {
        foreach ($parameters as $key => $value) {
            if (0 === strpos($key, 'database_')) {
                $parameters[substr($key, 9)] = $value;
                $key = substr($key, 9);
                $this->$key = $value;
            }
        }
    }

    /**
     * @see StepInterface
     */
    public function getFormType()
    {
        return new DoctrineStepType();
    }

    /**
     * @see StepInterface
     */
    public function checkRequirements()
    {
        $messages = array();

        if (!class_exists('\PDO')) {
            $messages[] = 'PDO extension is mandatory.';
        } else {
            $drivers = \PDO::getAvailableDrivers();
            if (0 == count($drivers)) {
                $messages[] = 'Please install PDO drivers.';
            }
        }

        return $messages;
    }

    /**
     * @see StepInterface
     */
    public function checkOptionalSettings()
    {
        return array();
    }

    /**
     * @see StepInterface
     */
    public function update(StepInterface $data)
    {
        $parameters = array();

        foreach ($data as $key => $value) {
            $parameters['database_'.$key] = $value;
        }

        return $parameters;
    }

    /**
     * @see StepInterface
     */
    public function getTemplate()
    {
        return 'ClubConfiguratorBundle:Configurator/Step:doctrine.html.twig';
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
