<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';

if (!is_writeable('../app/cache') && is_file('setup.php')) {
    header('Location: setup.php');
    exit;
}

require_once __DIR__.'/../app/AppKernel.php';
$kernel = new AppKernel('prod', false);

$apc = (function_exists('apc_cache_info')) ? true : false;
if ($apc) {
    require_once __DIR__.'/../app/AppCache.php';
    $kernel = new AppCache($kernel);

    if (isset($_SERVER['HTTP_HOST'])) {
        $prefix = $_SERVER['HTTP_HOST'];
    } else {
        $prefix = 'sf2';
    }

    $loader = new ApcClassLoader($prefix, $loader);
    $loader->register(true);
} else {
    $kernel->loadClassCache();
}

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
