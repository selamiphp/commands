<?php
declare(strict_types=1);

namespace Selami\Command\Server;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\LogicException;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Exception\RuntimeException;
use Symfony\Component\Process\Exception\InvalidArgumentException as ProcessInvalidArgumentException;

class ServerRun extends Command
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

        $output->writeln(' ');
        $output->writeln(
            '<comment>-----------------------------'
            . 'SELAMI WEB SERVER'
            . '-----------------------------------</comment>'
        );
        $output->writeln(' ');

        $output->writeln(' <comment>Usage:</comment>');
        $output->writeln('     selami server:run [options]');
        $output->writeln(' ');

        $output->writeln(' <comment>Available Options:</comment>');
        $output->writeln('     <info>--host  </info>'
            . '        Sets host name. <comment>Default: 127.0.0.1</comment>');
        $output->writeln('     <info>--public</info>        '
            . 'Sets public folder that server will be run. <comment>Default: ./public</comment>');
        $output->writeln(' ');

        $output->writeln('<comment>-------------------------------------------'
            . '--------------------------------------</comment>');
        $output->writeln(' ');

        $output->writeln(
            sprintf(
                'Starting Selami Skeleton App local web server from port 8080 on 127.0.0.1 at %s',
                $publicFolder
            )
        );
        $process = new Process('php -S ' . $hostName . ':8080 -t ' . $publicFolder);
        $process->setTimeout(null);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output->writeln($process->getOutput());
    }
}
