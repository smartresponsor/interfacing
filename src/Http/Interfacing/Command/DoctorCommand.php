<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Http\Interfacing\Command;

use App\Service\Interfacing\Doctor\DoctorReport;
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
#[AsCommand(name: 'interfacing:doctor-json', description: 'Interfacing doctor report as JSON (machine-readable).')]
final class DoctorCommand extends Command
{
    /**
     * @param \App\Service\Interfacing\Doctor\DoctorReport $report
     */
    public function __construct(private readonly DoctorReport $report)
    {
        parent::__construct();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln((string)json_encode($this->report->build(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return Command::SUCCESS;
    }
}
