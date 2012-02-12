<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Club\ConfiguratorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Club\ConfiguratorBundle\Configurator\Step\DoctrineStep;
use Club\ConfiguratorBundle\Configurator\Step\SecretStep;

/**
 * ClubConfiguratorBundle.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Marc Weistroff <marc.weistroff@sensio.com>
 */
class ClubConfiguratorBundle extends Bundle
{
    public function boot()
    {
        $configurator = $this->container->get('club.configurator.webconfigurator');
        $configurator->addStep(new DoctrineStep($configurator->getParameters()));
        $configurator->addStep(new SecretStep($configurator->getParameters()));
    }
}
