<?php

declare(strict_types=1);

namespace App\Presentation\LiveComponent\Interfacing;

use App\ServiceInterface\Interfacing\Doctor\InterfacingDoctorServiceInterface;
use App\Support\Doctor\DoctorReportInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_doctor', template: 'interfacing/doctor/component.html.twig')]
final class InterfacingDoctorComponent
{
    #[LiveProp(writable: true)]
    public string $query = '';

    #[LiveProp(writable: true)]
    public bool $onlyIssue = false;

    public function __construct(private readonly InterfacingDoctorServiceInterface $service)
    {
    }

    public function report(): DoctorReportInterface
    {
        return $this->service->report();
    }

    public function match(string $value): bool
    {
        $query = trim($this->query);
        if ('' === $query) {
            return true;
        }

        return str_contains(mb_strtolower($value), mb_strtolower($query));
    }
}
