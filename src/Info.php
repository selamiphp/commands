<?php
declare(strict_types=1);

namespace Selami\Command;

use Selami\Console\Command as SelamiCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class Info extends SelamiCommand
{
    /**
     * @inheritdoc
     * @throws InvalidArgumentException
     */
    protected function configure() : void
    {
        $this
            ->setName('info')
            ->setDescription('Displays configuration.');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $config = $this->container->get(Config::class);
        $output->writeln(json_encode($config->toArray(), JSON_PRETTY_PRINT));
    }
}
