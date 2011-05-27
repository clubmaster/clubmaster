<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\GeneratorBundle\Manipulator;

use Symfony\Component\ClassLoader\UniversalClassLoader;

/**
 * Changes the PHP code of the autoload.php file.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class AutoloaderManipulator extends Manipulator
{
    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function addNamespace($namespace)
    {
        $tokens = token_get_all(file_get_contents($this->filename));
        $this->setCode($tokens);

        // get all registered namespaces
        $namespaces = array();
        while ($token = $this->next()) {
            if (is_array($token) && T_OBJECT_OPERATOR === $token[0] && '->' === $token[1]) {
                $token = $this->next();
                if (is_array($token) && T_STRING === $token[0] && 'registerNamespaces' === $token[1]) {
                    // (
                    $this->next();

                    // array
                    $token = $this->next();
                    if (is_array($token) && T_ARRAY === $token[0]) {
                        // (
                        $this->next();

                        if (!$namespaces = $this->parseNamespaces()) {
                            return false;
                        }
                    }
                }
            }
        }

        var_export($namespaces);
    }

    private function parseNamespaces()
    {
        $namespaces = array();
        $code = array();
        $namespace = null;
        while ($token = $this->next()) {
            $next = $this->peek();

            $code[] = $token;

            // end of the array
            if (')' === $this->value($token) && ')' === $this->value($next) && ';' === $this->value($this->peek(2))) {
                if (null !== $namespace) {
                    $namespaces[$namespace] = $this->getDirectories(array_slice($code, 0, -1));
                }

                return $namespaces;
            }

            if (is_array($next) && T_DOUBLE_ARROW === $next[0]) {
                $this->next();

                if (null !== $namespace) {
                    $namespaces[$namespace] = $this->getDirectories(array_slice($code, 0, -1));
                }
                $code = array();

                $namespace = substr($token[1], 1, -1);
            }
        }
    }

    private function getDirectories(array $tokens)
    {
        $current = $this->tokens;
        $this->setCode($tokens);
        $directories = array();
        $directory = '';
        $inArray = false;
        while ($token = $this->next()) {
            if (is_array($token) && T_ARRAY === $token[0]) {
                $this->next();
                $inArray = true;

                continue;
            }

            parse_directory:
            if (!$directory = $this->getDirectory($token)) {
                $directories = array();
                break ;
            }

            $token = $this->next();
            $end = ',';
            if ($inArray) {
                if (',' !== $this->value($token)) {
                    $token = $this->next();

                    goto parse_directory;
                }

                $end = ')';
            }

            if ($end !== $this->value($token)) {
                $directories = array();
                break;
            }

            $directories[] = $directory;
        }

        $this->tokens = $current;

        return $directories;
    }

    private function getDirectory($token)
    {
        $directory = '';
        do {
            if (is_array($token) && T_DIR === $token[0]) {
                $directory .= dirname($this->filename);
            } elseif (is_array($token) && T_CONSTANT_ENCAPSED_STRING === $token[0]) {
                $directory .= substr($this->value($token), 1, -1);
            } elseif ('.' !== $this->value($token)) {
                return $directory;
            }
        } while ($token = $this->next());

        return '';
    }
}
