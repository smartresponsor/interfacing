<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\ServiceInterface\Interfacing\Doctor;

use App\Support\Doctor\DoctorReportInterface;

interface InterfacingDoctorServiceInterface
{
    public function report(): DoctorReportInterface;
}
