<?php

if (!$iniPath = get_cfg_var('cfg_file_path')) {
    $iniPath = 'WARNING: not using a php.ini file';
}

echo "********************************\n";
echo "*                              *\n";
echo "*  Symfony requirements check  *\n";
echo "*                              *\n";
echo "********************************\n\n";
echo sprintf("php.ini used by PHP: %s\n\n", $iniPath);

// mandatory
echo_title("Mandatory requirements");
check(version_compare(phpversion(), '5.3.2', '>='), sprintf('Checking that PHP version is at least 5.3.2 (%s installed)', phpversion()), 'Install PHP 5.3.2 or newer (current version is '.phpversion(), true);
check(is_writable(__DIR__.'/../app/cache'), sprintf('Checking that app/cache/ directory is writable'), 'Change the permissions of the app/cache/ directory so that the web server can write in it', true);
check(is_writable(__DIR__.'/../app/logs'), sprintf('Checking that the app/logs/ directory is writable'), 'Change the permissions of the app/logs/ directory so that the web server can write in it', true);
check(function_exists('json_encode'), 'Checking that the json_encode() is available', 'Install and enable the json extension', true);
check(class_exists('Locale'), 'Checking that the intl extension is available', 'Install and enable the intl extension (used for validators)', false);
if (class_exists('Locale')) {
    $version = '';

    if (defined('INTL_ICU_VERSION')) {
        $version =  INTL_ICU_VERSION;
    } else {
        $reflector = new \ReflectionExtension('intl');

        ob_start();
        $reflector->info();
        $output = strip_tags(ob_get_clean());

        preg_match('/^ICU version +(?:=> )?(.*)$/m', $output, $matches);
        $version = $matches[1];
    }

    check(version_compare($version, '4.0', '>='), 'Checking that the intl ICU version is at least 4+', 'Upgrade your intl extension with a newer ICU version (4+)', false);
}

echo_title("Optional checks (Doctrine)");

check(class_exists('PDO'), 'Checking that PDO is installed', 'Install PDO (mandatory for Doctrine)', false);
if (class_exists('PDO')) {
    $drivers = PDO::getAvailableDrivers();
    check(count($drivers), 'Checking that PDO has some drivers installed: '.implode(', ', $drivers), 'Install PDO drivers (mandatory for Doctrine)');
}

/**
 * Checks a configuration.
 */
function check($boolean, $message, $help = '', $fatal = false)
{
    echo $boolean ? "  OK        " : sprintf("\n\n[[%s]] ", $fatal ? ' ERROR ' : 'WARNING');
    echo sprintf("$message%s\n", $boolean ? '' : ': FAILED');

    if (!$boolean) {
        echo "            *** $help ***\n";
        if ($fatal) {
            die("You must fix this problem before resuming the check.\n");
        }
    }
}

function echo_title($title)
{
    echo "\n** $title **\n\n";
}
