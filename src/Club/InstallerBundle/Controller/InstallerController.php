<?php

namespace Club\InstallerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InstallerController extends Controller
{
  /**
   * @Route("/installer")
   * @Template()
   */
  public function indexAction()
  {
    return array();
  }

  /**
   * @Route("/installer/check")
   * @Template()
   */
  public function checkAction()
  {
    $majorProblems = array();
    $minorProblems = array();
    $phpini = false;

    // minimum
    if (!version_compare(phpversion(), '5.3.2', '>=')) {
      $version = phpversion();
      $majorProblems[] = <<<EOF
        You are running PHP version "<strong>$version</strong>", but Symfony
        needs at least PHP "<strong>5.3.2</strong>" to run. Before using Symfony, install
        PHP "<strong>5.3.2</strong>" or newer.
EOF;
    }

    if (!is_writable(__DIR__ . '/../../../../app/cache')) {
      $majorProblems[] = 'Change the permissions of the "<strong>app/cache/</strong>"
        directory so that the web server can write into it.';
    }

    if (!is_writable(__DIR__ . '/../../../../app/logs')) {
      $majorProblems[] = 'Change the permissions of the "<strong>app/logs/</strong>"
        directory so that the web server can write into it.';
    }

    // extensions
    if (!class_exists('DomDocument')) {
      $minorProblems[] = 'Install and enable the <strong>php-xml</strong> module.';
    }

    if (!defined('LIBXML_COMPACT')) {
      $minorProblems[] = 'Upgrade your <strong>php-xml</strong> extension with a newer libxml.';
    }

    if (!((function_exists('apc_store') && ini_get('apc.enabled')) || function_exists('eaccelerator_put') && ini_get('eaccelerator.enable') || function_exists('xcache_set'))) {
      $minorProblems[] = 'Install and enable a <strong>PHP accelerator</strong> like APC (highly recommended).';
    }

    if (!function_exists('token_get_all')) {
      $minorProblems[] = 'Install and enable the <strong>Tokenizer</strong> extension.';
    }

    if (!function_exists('mb_strlen')) {
      $minorProblems[] = 'Install and enable the <strong>mbstring</strong> extension.';
    }

    if (!function_exists('iconv')) {
      $minorProblems[] = 'Install and enable the <strong>iconv</strong> extension.';
    }

    if (!function_exists('utf8_decode')) {
      $minorProblems[] = 'Install and enable the <strong>XML</strong> extension.';
    }

    if (PHP_OS != 'WINNT' && !function_exists('posix_isatty')) {
      $minorProblems[] = 'Install and enable the <strong>php_posix</strong> extension (used to colorize the CLI output).';
    }

    if (!class_exists('Locale')) {
      $minorProblems[] = 'Install and enable the <strong>intl</strong> extension.';
    } else {
      $version = '';

      if (defined('INTL_ICU_VERSION')) {
        $version =  INTL_ICU_VERSION;
      } else {
        $reflector = new \ReflectionExtension('intl');

        ob_start();
        $reflector->info();
        $output = strip_tags(ob_get_clean());

        preg_match('/^ICU version (.*)$/m', $output, $matches);
        $version = $matches[1];
      }

      if(!version_compare($matches[1], '4.0', '>=')) {
        $minorProblems[] = 'Upgrade your intl extension with a newer ICU version (4+).';
      }
    }

    if (!class_exists('SQLite3') && !in_array('sqlite', PDO::getAvailableDrivers())) {
      $majorProblems[] = 'Install and enable the <strong>SQLite3</strong> or <strong>PDO_SQLite</strong> extension.';
    }

    if (!function_exists('json_encode')) {
      $majorProblems[] = 'Install and enable the <strong>json</strong> extension.';
    }

    // php.ini
    if (!ini_get('date.timezone')) {
      $phpini = true;
      $majorProblems[] = 'Set the "<strong>date.timezone</strong>" setting in php.ini<a href="#phpini">*</a> (like Europe/Paris).';
    }

    if (ini_get('short_open_tag')) {
      $phpini = true;
      $minorProblems[] = 'Set <strong>short_open_tag</strong> to <strong>off</strong> in php.ini<a href="#phpini">*</a>.';
    }

    if (ini_get('magic_quotes_gpc')) {
      $phpini = true;
      $minorProblems[] = 'Set <strong>magic_quotes_gpc</strong> to <strong>off</strong> in php.ini<a href="#phpini">*</a>.';
    }

    if (ini_get('register_globals')) {
      $phpini = true;
      $minorProblems[] = 'Set <strong>register_globals</strong> to <strong>off</strong> in php.ini<a href="#phpini">*</a>.';
    }

    if (ini_get('session.auto_start')) {
      $phpini = true;
      $minorProblems[] = 'Set <strong>session.auto_start</strong> to <strong>off</strong> in php.ini<a href="#phpini">*</a>.';
    }

    return array(
      'majorProblems' => $majorProblems,
      'minorProblems' => $minorProblems,
      'phpini' => $phpini,
      'php_ini_file' => get_cfg_var('cfg_file_path')
    );
  }

  /**
   * @Route("/installer/database")
   * @Template()
   */
  public function databaseAction()
  {
    return array();
  }

  /**
   * @Route("/installer/administrator")
   * @Template()
   */
  public function administratorAction()
  {
    return array();
  }

  /**
   * @Route("/installer/settings")
   * @Template()
   */
  public function settingsAction()
  {
    return array();
  }

  /**
   * @Route("/installer/confirm")
   * @Template()
   */
  public function confirmAction()
  {
    return array();
  }
}
