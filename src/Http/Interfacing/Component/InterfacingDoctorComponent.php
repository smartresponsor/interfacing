<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\Http\Interfacing\Component;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Doctor\InterfacingDoctorServiceInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_doctor', template: 'interfacing/doctor/component.html.twig')]
final class InterfacingDoctorComponent
{
    #[LiveProp(writable: true)]
    public string $query = '';

    #[LiveProp(writable: true)]
    public bool $onlyIssue = false;

    public function __construct(private readonly InterfacingDoctorServiceInterface $service) {}

    public function report(): \SmartResponsor\Interfacing\DomainInterface\Interfacing\Doctor\DoctorReportInterface
    {
        return $this->service->report();
    }

    public function match(string $value): bool
    {
        $q = trim($this->query);
        if ($q === '') { return true; }
        $value = mb_strtolower($value);
        $q = mb_strtolower($q);
        return str_contains($value, $q);
    }
}

