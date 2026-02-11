<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Infra\Interfacing\Command;

use App\DomainInterface\Interfacing\Security\PermissionNamerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'interfacing:permission-sample',
    description: 'Print Interfacing permission naming samples and conventions.'
)]
final class InterfacingDoctorCommand extends Command
{
    public function __construct(
        private readonly PermissionNamerInterface $permission,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $samples = [
            ['screen', 'category-admin', null],
            ['action', 'category-admin', 'save'],
            ['action', 'order-drill', 'refund'],
        ];

        foreach ($samples as [$kind, $screen, $action]) {
            if ($kind === 'screen') {
                $output->writeln('screen: ' . $screen . ' => ' . $this->permission->screen($screen));
                continue;
            }
            $output->writeln('action: ' . $screen . '.' . $action . ' => ' . $this->permission->action($screen, (string) $action));
        }

        $output->writeln('');
        $output->writeln('Role convention examples:');
        $output->writeln('- ROLE_INTERFACING_ADMIN');
        $output->writeln('- ROLE_INTERFACING_SCREEN_CATEGORY_ADMIN');
        $output->writeln('- ROLE_INTERFACING_ACTION_CATEGORY_ADMIN_SAVE');

        return Command::SUCCESS;
    }
}
