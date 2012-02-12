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

use Club\ConfiguratorBundle\Configurator\Form\SecretStepType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Secret Step.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SecretStep implements StepInterface
{
    /**
     * @Assert\NotBlank
     */
    public $secret;

    /**
     * @Assert\NotBlank
     */
    public $locale;

    public function __construct(array $parameters)
    {
        $this->secret = $parameters['secret'];

        if ('ThisTokenIsNotSoSecretChangeIt' == $this->secret) {
            $this->secret = hash('sha1', uniqid(mt_rand()));
        }
    }

    /**
     * @see StepInterface
     */
    public function getFormType()
    {
        return new SecretStepType();
    }

    /**
     * @see StepInterface
     */
    public function checkRequirements()
    {
        return array();
    }

    /**
     * checkOptionalSettings
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
      return array(
        'secret' => $data->secret,
        'locale' => $data->locale
      );
    }

    /**
     * @see StepInterface
     */
    public function getTemplate()
    {
        return 'ClubConfiguratorBundle:Configurator/Step:secret.html.twig';
    }
}
