<?php

declare(strict_types=1);

namespace App\Interfacing\Command;

use App\Interfacing\Service\Doctor\InterfaceDoctorReportService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'interfacing:doctor-json', description: 'Interfacing doctor report as JSON (machine-readable).')]
final class InterfaceDoctorJsonCommand extends Command
{
    public function __construct(private readonly InterfaceDoctorReportService $report)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln((string) json_encode($this->report->build(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return Command::SUCCESS;
    }
}
