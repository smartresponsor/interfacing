<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Contract\Doctor;

use App\Interfacing\ServiceInterface\Doctor\InterfaceDoctorIssueInterface;

final readonly class InterfaceDoctorIssue implements InterfaceDoctorIssueInterface
{
    public function __construct(private string $level, private string $text, private string $code)
    {
        if ('' === $level || '' === $text || '' === $code) {
            throw new \InvalidArgumentException('InterfaceDoctorIssue field must not be empty.');
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
