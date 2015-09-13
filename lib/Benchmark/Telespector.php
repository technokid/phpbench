<?php

/*
 * This file is part of the PHP Bench package
 *
 * (c) Daniel Leech <daniel@dantleech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpBench\Benchmark;

use Symfony\Component\Process\Process;

/**
 * Build and execute parameterized scripts in separate processes.
 * The scripts should return a JSON encoded string.
 */
class Telespector
{
    /**
     * @var string
     */
    private $bootstrap;

    /**
     * @var string
     */
    private $configDir;

    /**
     * @param mixed string
     */
    public function __construct($bootstrap, $configPath)
    {
        $this->bootstrap = $bootstrap;
        $this->configDir = dirname($configPath);
    }

    public function execute($template, array $parameters)
    {
        $bootstrap = $this->getBootstrapPath();
        if ($bootstrap && !file_exists($bootstrap)) {
            throw new \InvalidArgumentException(sprintf(
                'Bootstrap file "%s" does not exist',
                $bootstrap
            ));
        }

        if (!file_exists($template)) {
            throw new \RuntimeException(sprintf(
                'Could not find script template "%s"',
                $template
            ));
        }

        $parameters['bootstrap'] = $bootstrap;

        $tokens = array();
        foreach ($parameters as $key => $value) {
            $tokens['{{ ' . $key . ' }}'] = $value;
        }

        $templateBody = file_get_contents($template);
        $script = str_replace(
            array_keys($tokens),
            array_values($tokens),
            $templateBody
        );

        $scriptPath = tempnam(sys_get_temp_dir(), 'PhpBench');
        file_put_contents($scriptPath, $script);

        $process = new Process(PHP_BINARY . ' ' . $scriptPath);
        $process->run();
        unlink($scriptPath);

        if (false === $process->isSuccessful()) {
            throw new \RuntimeException(sprintf(
                'Could not execute script: %s %s',
                $process->getErrorOutput(),
                $process->getOutput()
            ));
        }

        $output = $process->getOutput();
        $result = json_decode($output, true);

        if (null === $result) {
            throw new \RuntimeException(sprintf(
                'Could not decode return value from script from template "%s" (should be a JSON encoded string): %s',
                $template,
                $output
            ));
        }

        return $result;
    }

    private function getBootstrapPath()
    {
        if (!$this->bootstrap) {
            return;
        }

        // if the path is absolute, return it unmodified
        if ('/' === substr($this->bootstrap, 0, 1)) {
            return $this->bootstrap;
        }

        return $this->configDir . '/' . $this->bootstrap;
    }
}
