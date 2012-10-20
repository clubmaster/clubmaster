<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';

if (!is_writeable('../app/cache') && is_file('setup.php')) {
    header('Location: setup.php');
    exit;
}

$apc = (function_exists('apc_cache_info')) ? true : false;

// Use APC for autoloading to improve performance
// Change 'sf2' by the prefix you want in order to prevent key conflict with another application
if ($apc) {
    $loader = new ApcClassLoader('sf2', $loader);
    $loader->register(true);
}

require_once __DIR__.'/../app/AppKernel.php';

if ($apc) {
    require_once __DIR__.'/../app/AppCache.php';
}

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();

if ($apc) {
    $kernel = new AppCache($kernel);
}

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
