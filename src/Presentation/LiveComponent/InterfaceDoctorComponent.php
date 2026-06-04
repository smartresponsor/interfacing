<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\LiveComponent;

use App\Interfacing\ServiceInterface\Doctor\InterfaceDoctorReportInterface;
use App\Interfacing\ServiceInterface\Doctor\InterfaceDoctorServiceInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_doctor', template: 'doctor/component.html.twig')]
final class InterfaceDoctorComponent
{
    #[LiveProp(writable: true)]
    public string $query = '';

    #[LiveProp(writable: true)]
    public bool $onlyIssue = false;

    public function __construct(private readonly InterfaceDoctorServiceInterface $service)
    {
    }

    public function __invoke(): void
    {
    }

    public function report(): InterfaceDoctorReportInterface
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
