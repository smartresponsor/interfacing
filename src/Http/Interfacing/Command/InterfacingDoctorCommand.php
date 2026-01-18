<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Http\Interfacing\Command;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'interfacing:doctor')]
final class InterfacingDoctorCommand extends Command
{
    public function __construct(private readonly DoctorReportBuilderInterface $reportBuilder)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $report = $this->reportBuilder->build();

        $output->writeln('Interfacing Doctor');
        $output->writeln('Screen: ' . count($report['screen']));
        $output->writeln('Layout: ' . count($report['layout']));

        return Command::SUCCESS;
    }
}
