<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Support\Doctor;

final readonly class DoctorIssue implements DoctorIssueInterface
{
    public function __construct(private string $level, private string $text, private string $code)
    {
        if ('' === $level || '' === $text || '' === $code) {
            throw new \InvalidArgumentException('DoctorIssue field must not be empty.');
        }
    }

    public function level(): string
    {
        return $this->level;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function code(): string
    {
        return $this->code;
    }
}
