<?php

namespace Club\UserBundle\Listener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CacheClear
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function onKernelRequest($event)
    {
        switch (true) {
        case HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType():
        case ($this->container->get('kernel')->getEnvironment() == 'dev'):
            return;
        }

        $url = $this->container->get('request')->getUri();
        $path = $this->container->getParameter('kernel.cache_dir');
        $old_path = $this->container->getParameter('kernel.cache_dir').'_old';
        $hash_file = $this->container->getParameter('kernel.cache_dir').'/config_hash';
        $hash_value = $this->getHash();

        if (!file_exists($hash_file)) {
            $this->writeHashFile($hash_file, $hash_value);

            return;
        } else {
            $old = file_get_contents($hash_file);

            if ($old == $hash_value) {
                return;
            }

            $this->writeHashFile($hash_file, $hash_value);
        }

        if (is_dir($old_path)) {
            $this->container->get('filesystem')->remove($old_path);
        }

        rename($path, $old_path);
        $this->container->get('filesystem')->remove($old_path);

        header('Location: '.$url);
        exit;
    }

    protected function getHash()
    {
        $files = array(
            $this->container->getParameter('kernel.root_dir').'/config/clubmaster.yml',
            $this->container->getParameter('kernel.root_dir').'/config/config.yml',
            $this->container->getParameter('kernel.root_dir').'/config/security.yml',
            $this->container->getParameter('kernel.root_dir').'/config/parameters.yml'
        );

        $data = '';
        foreach ($files as $file) {
            $data .= hash_file('md5', $file);
        }

        return hash('sha256', $data);
    }

    protected function writeHashFile($file, $data)
    {
        return file_put_contents($file, $data);
    }
}
