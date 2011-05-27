<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\GeneratorBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpKernel\KernelInterface;
use Sensio\Bundle\GeneratorBundle\Generator\BundleGenerator;
use Sensio\Bundle\GeneratorBundle\Manipulator\KernelManipulator;
use Sensio\Bundle\GeneratorBundle\Manipulator\AutoloaderManipulator;

/**
 * Initializes a new bundle.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class InitBundleCommand extends Command
{
    private $container;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDefinition(array(
                new InputOption('namespace', '', InputOption::VALUE_REQUIRED, 'The namespace of the bundle to create', null),
                new InputOption('dir', '', InputOption::VALUE_REQUIRED, 'The directory where to create the bundle', null),
                new InputOption('bundleName', '', InputOption::VALUE_REQUIRED, 'The optional bundle name', null),
                new InputOption('format', '', InputOption::VALUE_REQUIRED, 'Use the format for configuration files (php, xml, yml, or , annotation)', null),
            ))
            ->setHelp(<<<EOT
The <info>init:bundle</info> command helps you generates new bundles.

By default, the command interacts with the developer to tweak the generation.
Any passed option will be used as a default value for the interaction
(<comment>--namespace</comment> is the only one needed if you follow the
conventions):

<info>./app/console init:bundle --namespace='Foo/BarBundle'</info>

If you want to disable any user interaction, use `--no-interaction` but don't
forget to pass all needed options:

<info>./app/console init:bundle "Vendor\HelloBundle" src [bundleName]</info>

Note that the bundle namespace must end with "Bundle".
EOT
            )
            ->setName('init:bundle')
        ;
    }

    /**
     * @see Command
     *
     * @throws \InvalidArgumentException When namespace doesn't end with Bundle
     * @throws \RuntimeException         When bundle can't be executed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->container = $this->getApplication()->getKernel()->getContainer();

        $generator = new BundleGenerator($this->container->get('filesystem'), __DIR__.'/../Resources/skeleton');

        if ($input->isInteractive()) {
            if (false === $elements = $this->getInteractiveParameters($generator, $input, $output)) {
                return 1;
            }
            list($namespace, $bundle, $dir, $format) = $elements;
        } else {
            list($namespace, $bundle, $dir, $format) = $this->getParameters($generator, $input, $output);
        }

        $output->writeln(array(
            '',
            $this->getHelper('formatter')->formatBlock('Bundle generation', 'bg=blue;fg=white', true),
            '',
        ));

//        $generator->generate($namespace, $bundle, realpath($dir).'/', $format);
        $output->writeln('Generating the bundle code: <info>OK</info>');

        $errors = array();
/*
        // register the bundle in the Kernel class
        if ($err = $this->updateKernel($output, $this->getApplication()->getKernel(), $namespace, $bundle)) {
            $output->writeln('<fg=red>KO</>');
            $errors = array_merge($errors, $err);
        } else {
            $output->writeln('<info>OK</info>');
        }
*/
        // register namespace in the autoloader
        $filename = realpath($this->container->getParameter('kernel.root_dir').'/autoload.php');
        if (!in_array($filename, get_included_files())) {
// FIXME: unable to find the autoloader
        }
        $autoloader = new AutoloaderManipulator($filename);
        if (!$autoloader->addNamespace($namespace)) {
        }

        // errors?
        if (!$errors) {
            $output->writeln(array(
                '',
                $this->getHelper('formatter')->formatBlock('Start building your bundle!', 'bg=blue;fg=white', true),
                '',
            ));
        } else {
            $output->writeln(array(
                '',
                $this->getHelper('formatter')->formatBlock(array(
                    'Some problems occurred during generation.',
                    'You must fix them before using the bundle.',
                ), 'error', true),
                '',
            ));

            $output->writeln($errors);
        }

        $output->writeln(array(
            '- Ensure that the namespace is registered with the autoloader.',
            '',
            '- If using routing, import the bundle\'s routing resource.',
        ));
    }

    private function getParameters(BundleGenerator $generator, InputInterface $input, OutputInterface $output)
    {
        foreach (array('namespace', 'dir') as $option) {
            if (null === $input->getOption($option)) {
                throw new \RuntimeException(sprintf('The "%s" option must be provided.', $option));
            }
        }

        $namespace = $generator->validateNamespace($input->getOption('namespace'));

        if (!$bundle = $input->getOption('bundleName')) {
            $bundle = strtr($namespace, array('\\' => ''));
        }
        $bundle = $generator->validateBundleName($bundle);

        $dir = $generator->validateTargetDir($input->getOption('dir'), $bundle, $namespace);

        $format = $input->getOption('format') ?: 'annotation';

        return array($namespace, $bundle, $dir, $format);
    }

    private function getInteractiveParameters(BundleGenerator $generator, InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getHelper('dialog');
        $formatter = $this->getHelper('formatter');

        $output->writeln($formatter->formatBlock('Welcome to the Symfony2 bundle generator', 'bg=blue;fg=white', true));

        // namespace
        $output->writeln(array(
            '',
            'Each bundle is hosted under a namespace (like <comment>Acme/Bundle/BlogBundle</comment>).',
            'The namespace should begin with a "vendor" name like your company name, your',
            'project name, or your client name, followed by one or more optional category',
            'sub-namespaces, and it should end with the bundle name itself',
            '(which must have <comment>Bundle</comment> as a suffix).',
            '',
        ));
        $namespace = $dialog->askAndValidate($output, $this->getQuestion('Bundle namespace', $input->getOption('namespace')), array($generator, 'validateNamespace'), false, $input->getOption('namespace'));
        $namespace = $generator->validateNamespace($namespace);

        // bundle name
        $bundle = $input->getOption('bundleName') ?: strtr($namespace, array('\\' => ''));
        $output->writeln(array(
            '',
            'In your code, a bundle is often referenced by its name. It can be the',
            'concatenation of all namespace parts but it\'s really up to you to come',
            'up with a unique name (a good practice is to start with the vendor name).',
            'Based on the namespace, we suggest <comment>'.$bundle.'</comment>.',
            '',
        ));
        $bundle = $dialog->askAndValidate($output, $this->getQuestion('Bundle name', $bundle), array($generator, 'validateBundleName'), false, $bundle);
        $bundle = $generator->validateBundleName($bundle);

        // target dir
        $dir = $input->getOption('dir') ?: dirname($this->container->getParameter('kernel.root_dir')).'/src';
        $output->writeln(array(
            '',
            'The bundle can be generated anywhere, but remember to update the autoloader',
            'accordingly. The suggested defaults uses the standard conventions.',
            '',
        ));
        $dir = $dialog->askAndValidate($output, $this->getQuestion('Target directory', $dir), function ($dir) use ($generator, $bundle, $namespace) { return $generator->validateTargetDir($dir, $bundle, $namespace); }, false, $dir);
        $dir = $generator->validateTargetDir($dir, $bundle, $namespace);

        // format
        $format = $input->getOption('format') ?: 'annotation';
        $output->writeln(array(
            '',
            'Determine the format to use for the generated configuration.',
            '',
        ));
        $format = $dialog->askAndValidate($output, $this->getQuestion('Configuration format (yml, xml, php, or annotation)', $format), array($generator, 'validateFormat'), false, $format);
        $format = $generator->validateFormat($format);

        // optional files to generate
        $files = array();
        $output->writeln(array(
            '',
            'To help you getting started faster, the command can generate some',
            'code snippets for you.',
            '',
        ));

        if ($dialog->askConfirmation($output, $this->getQuestion('Do you want to generate a simple controller with a template', 'yes', '?'), true)) {
            $files[] = 'controller';
        }
// FIXME: add more options
// Controller with template and routing
// Unit test, functional test (if controller)
// config avec un service / parameters
// CLI command
// Doc avec .rst
// Translations
// assets

        // summary
        $output->writeln(array(
            '',
            $formatter->formatBlock('Summary before generation', 'bg=blue;fg=white', true),
            '',
            sprintf("You are going to generate a \"<info>%s\\%s</info>\" bundle\nin \"<info>%s</info>\" using the \"<info>%s</info>\" format.", $namespace, $bundle, $dir, $format),
            '',
        ));

        if (!$dialog->askConfirmation($output, $this->getQuestion('Do you confirm generation', 'no', '?'), false)) {
            $output->writeln('<error>Command aborted</error>');

            return false;
        }

        return array($namespace, $bundle, $dir, $format);
    }

    private function getQuestion($question, $default, $sep = ':')
    {
        return $default ? sprintf('<info>%s</info> [<comment>%s</comment>]%s ', $question, $default, $sep) : sprintf('%s%s ', $question, $sep);
    }

    private function updateKernel(OutputInterface $output, KernelInterface $kernel, $namespace, $bundle)
    {
        $output->write('Enabling the bundle inside the Kernel: ');
        $kernel = new KernelManipulator($kernel);
        if (!$kernel->addBundle($namespace.'\\'.$bundle)) {
            $reflected = new \ReflectionObject($kernel);

            return array(
                sprintf('- Edit <comment>%s</comment>', $reflected->getFilename()),
                '  and add the following bundle in the <comment>AppKernel::registerBundles()</comment> method:',
                '',
                sprintf('      <comment>new %s(),</comment>', $namespace.'\\'.$bundle),
                '',
            );
        }
    }
}
