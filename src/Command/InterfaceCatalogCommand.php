<?php

declare(strict_types=1);

namespace App\Interfacing\Command;

use App\Interfacing\CatalogInterface\AttributeRegistry\InterfaceActionCatalogInterface;
use App\Interfacing\CatalogInterface\AttributeRegistry\InterfaceScreenCatalogInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'interfacing:catalog', description: 'List Interfacing screens and actions')]
final class InterfaceCatalogCommand extends Command
{
    public function __construct(
        private readonly InterfaceScreenCatalogInterface $screenCatalog,
        private readonly InterfaceActionCatalogInterface $actionCatalog,
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
