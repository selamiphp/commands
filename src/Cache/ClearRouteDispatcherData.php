<?php
declare(strict_types=1);

namespace Selami\Command\Cache;

use Selami\Console\Command as SelamiCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class ClearRouteDispatcherData extends SelamiCommand
{
    /**
     * @inheritdoc
     * @throws InvalidArgumentException
     */
    protected function configure() : void
    {
        $this
            ->setName('cache:clear-routes')
            ->setDescription('Clears generated routes data cache file.');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $config = $this->container->get('config');
        $routeCacheFile = $config['app']['cache_file'] ?? '';
        $unlinkResult  =  file_exists((string) $routeCacheFile)
            ? unlink($routeCacheFile) ? 'deleted.' : 'could\'t deleted'
            : 'does not exist!';
        $output->writeln('Route cache file '  .$routeCacheFile . ' ' . $unlinkResult);
    }
}
