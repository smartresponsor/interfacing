<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\ServiceInterface\Interfacing\Doctor;

use SmartResponsor\DomainInterface\Interfacing\Doctor\DoctorReportInterface;

interface InterfacingDoctorServiceInterface
{
    public function report(): DoctorReportInterface;
}

