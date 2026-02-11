<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Doctor;

/**
 *
 */

/**
 *
 */
interface DoctorReportNormalizerInterface
{
    /**
     * Canonical doctor report shape.
     *
     * @return array{meta:array,screen:array,layout:array,issue:array}
     */
    public function normalize(array $raw): array;
}
