<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Domain\Interfacing\Doctor;

use App\DomainInterface\Interfacing\Doctor\DoctorIssueInterface;

/**
 *
 */

/**
 *
 */
final readonly class DoctorIssue implements DoctorIssueInterface
{
    /**
     * @param string $level
     * @param string $text
     * @param string $code
     */
    public function __construct(private string $level, private string $text, private string $code)
    {
        if ($level === '' || $text === '' || $code === '') {
            throw new \InvalidArgumentException('DoctorIssue field must not be empty.');
        }
    }

    /**
     * @return string
     */
    public function level(): string { return $this->level; }

    /**
     * @return string
     */
    public function text(): string { return $this->text; }

    /**
     * @return string
     */
    public function code(): string { return $this->code; }
}

