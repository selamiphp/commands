<?php
declare(strict_types=1);

namespace Selami\Command\Cache;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class ClearConfig extends Command
{
    /**
     * @inheritdoc
     * @throws InvalidArgumentException
     */
    protected function configure() : void
    {
        $this
            ->setName('cache:clear-config')
            ->setDescription('Clears generated config file.');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $cachedConfigFiles = glob('./cache/*app_config.php');
        foreach ($cachedConfigFiles as $cachedConfigFile) {
            $unlinkResult  =  file_exists($cachedConfigFile)
                ? (unlink($cachedConfigFile) === true) ? 'deleted.':'could\'t deleted'
                :' file does not exist';
            $output->writeln($cachedConfigFile . ' ' . $unlinkResult);
        }
    }
}
