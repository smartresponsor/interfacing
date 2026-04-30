<?php

declare(strict_types=1);

namespace App\Interfacing\Support\Console;

use App\Interfacing\ServiceInterface\Interfacing\Doctor\InterfacingDoctorServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'interfacing:doctor', description: 'Interfacing doctor report (screen/layout/action).')]
final class InterfacingDoctorCommand extends Command
{
    public function __construct(private readonly InterfacingDoctorServiceInterface $service)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $report = $this->service->report();

        $output->writeln('Interfacing doctor report');
        $output->writeln('screen: '.count($report->screenItem()));
        $output->writeln('layout: '.count($report->layoutItem()));
        $output->writeln('action: '.count($report->actionItem()));
        $output->writeln('issue: '.count($report->issueItem()));
        $output->writeln('');

        foreach ($report->issueItem() as $issue) {
            $output->writeln('['.$issue->level().'] '.$issue->code().' - '.$issue->text());
        }

        return Command::SUCCESS;
    }
}
