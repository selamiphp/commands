<?php
declare(strict_types=1);

namespace Selami\Command\Cache;

use Selami\Console\Command as SelamiCommand;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class ClearAll extends SelamiCommand
{

    protected static $availableCommands = [
        'cache:clear-config',
        'cache:clear-routes',
        'cache:clear-view-data'
    ];
    /**
     * @inheritdoc
     * @throws InvalidArgumentException
     */
    protected function configure() : void
    {
        $this
            ->setName('cache:clear-all')
            ->setDescription('Clear all cached.');
    }

    /**
     * @inheritdoc
     * @throws CommandNotFoundException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        foreach (self::$availableCommands as $clearCommand) {
            $command = $this->getApplication()->find($clearCommand);
            $command->run(new ArrayInput(['command'=> $clearCommand]), $output);
        }
    }
}
