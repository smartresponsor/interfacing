<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Http\Interfacing\Command;

    use App\HttpInterface\Interfacing\Command\InterfacingCatalogCommandInterface;
use App\ServiceInterface\Interfacing\Registry\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\Registry\ScreenCatalogInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

    /**
     *
     */

    /**
     *
     */
    #[AsCommand(name: 'interfacing:catalog', description: 'List Interfacing screens and actions')]
final class InterfacingCatalogCommand extends Command implements InterfacingCatalogCommandInterface
{
    /**
     * @param \App\ServiceInterface\Interfacing\Registry\ScreenCatalogInterface $screenCatalog
     * @param \App\ServiceInterface\Interfacing\Registry\ActionCatalogInterface $actionCatalog
     */
    public function __construct(
        private readonly ScreenCatalogInterface $screenCatalog,
        private readonly ActionCatalogInterface $actionCatalog,
    ) {
        parent::__construct();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->screenCatalog->all() as $screen) {
            $output->writeln($screen->screenId() . ' | ' . $screen->title());
            foreach ($this->actionCatalog->allForScreen($screen->screenId()) as $action) {
                $output->writeln('  - ' . $action->actionId() . ' | ' . $action->title());
            }
        }

        return Command::SUCCESS;
    }
}

