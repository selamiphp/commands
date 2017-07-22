<?php
declare(strict_types=1);

namespace Selami\Command\Server;

use Selami\Console\Command as SelamiCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Exception\InvalidArgumentException as ProcessInvalidArgumentException;

class ServerRun extends SelamiCommand
{
    /**
     * @inheritdoc
     * @throws InvalidArgumentException
     */
    protected function configure() : void
    {
        $this
            ->setName('server:run')
            ->addOption('host', null, InputOption::VALUE_OPTIONAL, 'Hostname of the site', '127.0.0.1')
            ->addOption('public', null, InputOption::VALUE_OPTIONAL, 'Public web root.', './public')
            ->setDescription('Run web server locally');
    }

    /**
     * @inheritdoc
     * @throws RuntimeException
     * @throws ProcessFailedException
     * @throws LogicException
     * @throws ProcessInvalidArgumentException
     * @throws InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $hostName = $input->getOption('host');
        $publicFolder = $input->getOption('public');
        $output->writeln('Starting Selami Skeleton App local web server from port 8080 on 127.0.0.1 at '.$publicFolder);
        $process = new Process('php -S ' . $hostName . ':8080 -t ' . $publicFolder);
        $process->setTimeout(null);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output->writeln($process->getOutput());
    }
}
