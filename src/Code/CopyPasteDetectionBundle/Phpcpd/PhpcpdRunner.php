<?php

namespace Code\CopyPasteDetectionBundle\Phpcpd;

use Code\AnalyzerBundle\Analyzer\Runner\RunnerInterface;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\Process;

class PhpcpdRunner implements RunnerInterface
{
    /**
     * @var string
     */
    private $phpcpdExecutable;

    /**
     * @param string $phpcpdExecutable
     */
    public function __construct($phpcpdExecutable)
    {
        $this->phpcpdExecutable = $phpcpdExecutable;
    }

    /**
     * @inheritDoc
     */
    public function run($sourceDirectory, $workDirectory)
    {
        $pmdFilename = $this->ensureDirectoryWritable($workDirectory) . '/pmdcpd.xml';

        $processBuilder = new ProcessBuilder();
        $processBuilder
            ->add($this->phpcpdExecutable)
            ->add('--log-pmd')
            ->add($pmdFilename)
            ->add('--quiet')
            ->add($sourceDirectory);

        $process = $processBuilder->getProcess();

        $exitStatusCode = $process->run();

        if (!$process->isSuccessful() && $exitStatusCode != 1) {
            echo $process->getCommandLine().PHP_EOL;
            echo 'RC: ' . $exitStatusCode.PHP_EOL;
            echo 'Output: ' . $process->getOutput().PHP_EOL;
            echo 'Error output: ' . $process->getErrorOutput().PHP_EOL;
            throw new \Exception('phpcpd execution resulted in an error');
        }

        return $pmdFilename;
    }

    /**
     * Ensure directory exists and is writable
     *
     * @param string $directory
     * @return string
     * @throws \Exception
     */
    private function ensureDirectoryWritable($directory)
    {
        if (!file_exists($directory) && !mkdir($directory, 0777, true)) {
            throw new \Exception('Can\'t create data dir');
        }

        if (!is_writable($directory)) {
            throw new \Exception('Data dir not writable');
        }

        return $directory;
    }
}
