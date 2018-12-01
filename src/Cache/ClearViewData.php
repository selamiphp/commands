<?php
declare(strict_types=1);

namespace Selami\Command\Cache;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class ClearViewData extends Command
{
    private $config;

    public function __construct(array $config, ?string $name = null)
    {
        $this->config = $config;
        parent::__construct($name);
    }

    /**
     * @inheritdoc
     * @throws InvalidArgumentException
     */
    protected function configure() : void
    {
        $this
            ->setName('cache:clear-view-data')
            ->setDescription('Clears generated cache file.');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output) : void
    {
        $viewCachePath = $this->config[$this->config['type']]['cache'];
        $output->writeln('Files under '.$viewCachePath .' will be deleted.');
        if ((string) $viewCachePath !== '') {
            foreach (glob($viewCachePath . '/*') as $folder) {
                $files = glob($folder . '/*');
                $output->writeln('Files under ' . $folder . ' will be deleted.');
                foreach ($files as $file) {
                    $unlinkResult = file_exists($file)
                        ? (unlink($file) === true) ? 'deleted.' : 'could\'t deleted'
                        : ' file does not exist';
                    $output->writeln($file . ' ' . $unlinkResult);
                }
                rmdir($folder);
                $output->writeln($folder . ' emptied.');
            }
        }
        $output->writeln($viewCachePath .' emptied.');
    }
}
