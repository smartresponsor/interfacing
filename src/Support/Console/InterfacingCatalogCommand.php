<?php

declare(strict_types=1);

namespace App\Interfacing\Support\Console;

use App\Interfacing\ServiceInterface\Interfacing\Registry\ActionCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Registry\ScreenCatalogInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'interfacing:catalog', description: 'List Interfacing screens and actions')]
final class InterfacingCatalogCommand extends Command
{
    public function __construct(
        private readonly ScreenCatalogInterface $screenCatalog,
        private readonly ActionCatalogInterface $actionCatalog,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->screenCatalog->all() as $screen) {
            $output->writeln($screen->screenId().' | '.$screen->title());
            foreach ($this->actionCatalog->allForScreen($screen->screenId()) as $action) {
                $output->writeln('  - '.$action->actionId().' | '.$action->title());
            }
        }

        return Command::SUCCESS;
    }
}
