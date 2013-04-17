<?php

namespace Club\InstallerBundle\Helper;

class InstallerFile
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function installerOpen($exception=false)
    {
        $file = $this->container->get('kernel')->getRootDir().'/installer';

        if (file_exists($file)) return true;

        return false;
    }

    public function clearCache($url)
    {
        $path = $this->container->getParameter('kernel.cache_dir');
        $old_path = $this->container->getParameter('kernel.cache_dir').'_old';

        if (is_dir($old_path)) {
            $this->container->get('filesystem')->remove($old_path);
        }

        rename($path, $old_path);
        $this->container->get('filesystem')->remove($old_path);

        header('Location: '.$url);
        exit;
    }
}
