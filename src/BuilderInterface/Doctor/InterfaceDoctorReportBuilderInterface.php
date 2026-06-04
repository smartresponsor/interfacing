<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\BuilderInterface\Doctor;

interface InterfaceDoctorReportBuilderInterface
{
    /** @return array<string, mixed> */
    public function build(): array;
}
