<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\DoctrineBundle\DoctrineBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new Symfony\Bundle\DoctrineMigrationsBundle\DoctrineMigrationsBundle(),
            new Symfony\Bundle\DoctrineFixturesBundle\DoctrineFixturesBundle(),
            new Club\UserBundle\ClubUserBundle(),
            new Club\MailBundle\ClubMailBundle(),
            new Club\ShopBundle\ClubShopBundle(),
            new Club\RestBundle\ClubRestBundle(),
            new Club\AccountBundle\ClubAccountBundle(),
            new Club\TaskBundle\ClubTaskBundle(),
            new Club\LogBundle\ClubLogBundle(),
            new Club\EventBundle\ClubEventBundle(),
            new Club\TeamBundle\ClubTeamBundle(),
            new Club\ForumBundle\ClubForumBundle(),
            new Club\WeatherBundle\ClubWeatherBundle(),
            new Club\LayoutBundle\ClubLayoutBundle(),
            new Club\InstallerBundle\ClubInstallerBundle(),
            new Club\MenuBundle\ClubMenuBundle(),
            new Club\FeedbackBundle\ClubFeedbackBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
