<?php
declare(strict_types=1);

namespace Selami\Command\Cache;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class ClearRouteDispatcherData extends Command
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
        $files = glob('./cache/*fastroute.cache');
        $output->writeln('FastRoute cache files under ./cache will be deleted.');
        foreach ($files as $file) {
            $unlinkResult = file_exists($file)
                ? (unlink($file) === true) ? 'deleted.' : 'could\'t deleted'
                : ' file does not exist';
            $output->writeln($file . ' ' . $unlinkResult);
        }
    }
}
