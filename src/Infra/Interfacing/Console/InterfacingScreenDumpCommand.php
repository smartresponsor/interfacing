Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\Infra\Interfacing\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'interfacing:screen:dump',
    description: 'Show registered Interfacing screens and their routes.',
)]
final class InterfacingScreenDumpCommand extends Command
{
    public function __construct(
        private readonly ParameterBagInterface $parameters,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $value = $this->parameters->get('interfacing.screens');

        if (!is_array($value)) {
            $output->writeln('<error>Parameter "interfacing.screens" is not configured as array.</error>');
            return Command::FAILURE;
        }

        if ($value === []) {
            $output->writeln('<comment>No Interfacing screens registered in parameter "interfacing.screens".</comment>');
            return Command::SUCCESS;
        }

        $output->writeln('<info>Interfacing screens:</info>');

        foreach ($value as $screen) {
            if (!is_array($screen)) {
                continue;
            }

            $id = isset($screen['id']) ? (string) $screen['id'] : '';
            $route = isset($screen['route']) ? (string) $screen['route'] : '';
            $domain = isset($screen['domain']) ? (string) $screen['domain'] : '';
            $notes = isset($screen['notes']) ? (string) $screen['notes'] : '';

            if ($id === '') {
                continue;
            }

            $line = sprintf('- %s', $id);

            if ($domain !== '') {
                $line .= sprintf(' [domain: %s]', $domain);
            }

            if ($route !== '') {
                $line .= sprintf(' (route: %s)', $route);
            }

            if ($notes !== '') {
                $line .= sprintf(' - %s', $notes);
            }

            $output->writeln($line);
        }

        return Command::SUCCESS;
    }
}
