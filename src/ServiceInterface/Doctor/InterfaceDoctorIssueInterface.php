<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ServiceInterface\Doctor;

interface InterfaceDoctorIssueInterface
{
    public function level(): string;

    public function text(): string;

    public function code(): string;
}
