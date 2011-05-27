<?php

// autoloader
spl_autoload_register(function ($class) {
    $class = ltrim($class, '\\');
    if (0 === strpos($class, 'Sensio\\Bundle\\GeneratorBundle\\')) {
        require_once __DIR__.'/../../../../'.str_replace('\\', '/', $class).'.php';
    }
});
