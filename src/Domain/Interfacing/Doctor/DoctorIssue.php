<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Domain\Interfacing\Doctor;

use App\DomainInterface\Interfacing\Doctor\DoctorIssueInterface;

final class DoctorIssue implements DoctorIssueInterface
{
    public function __construct(private readonly string $level, private readonly string $text, private readonly string $code)
    {
        if ($level === '' || $text === '' || $code === '') {
            throw new \InvalidArgumentException('DoctorIssue field must not be empty.');
        }
    }

    public function level(): string { return $this->level; }
    public function text(): string { return $this->text; }
    public function code(): string { return $this->code; }
}

