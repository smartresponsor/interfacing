<?php

declare(strict_types=1);

namespace App\Interfacing\Command;

use App\Interfacing\BuilderInterface\Doctor\InterfaceDoctorReportBuilderInterface;
use App\Interfacing\NormalizerInterface\Doctor\InterfaceDoctorReportNormalizerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'interfacing:doctor-summary', description: 'Interfacing doctor summary (screen/layout counts).')]
final class InterfaceDoctorSummaryCommand extends Command
{
    public function __construct(
        private readonly InterfaceDoctorReportBuilderInterface $reportBuilder,
        private readonly InterfaceDoctorReportNormalizerInterface $normalizer,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $raw = $this->reportBuilder->build();
        $report = $this->normalizer->normalize($raw);

        $output->writeln('Interfacing doctor summary');
        $output->writeln('screen: '.count($report['screen']));
        $output->writeln('layout: '.count($report['layout']));
        $output->writeln('issue: '.count($report['issue']));

        return Command::SUCCESS;
    }
}
