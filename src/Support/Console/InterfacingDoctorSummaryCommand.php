<?php

declare(strict_types=1);

namespace App\Support\Console;

use App\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use App\ServiceInterface\Interfacing\Doctor\DoctorReportNormalizerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'interfacing:doctor-summary', description: 'Legacy doctor summary (screen/layout counts).')]
final class InterfacingDoctorSummaryCommand extends Command
{
    public function __construct(
        private readonly DoctorReportBuilderInterface $reportBuilder,
        private readonly DoctorReportNormalizerInterface $normalizer,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $raw = $this->reportBuilder->build();
        $report = $this->normalizer->normalize($raw);

        $output->writeln('Interfacing doctor summary (legacy)');
        $output->writeln('screen: '.count($report['screen']));
        $output->writeln('layout: '.count($report['layout']));
        $output->writeln('issue: '.count($report['issue']));

        return Command::SUCCESS;
    }
}
