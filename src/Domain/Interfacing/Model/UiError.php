<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Model;

/**
 *
 */

/**
 *
 */
final class UiError
{
    private string $field;
    private string $message;

    /**
     * @param string $field
     * @param string $message
     */
    public function __construct(string $field, string $message)
    {
        if ($message === '') {
            throw new \InvalidArgumentException('UiError message must not be empty.');
        }
        $this->field = $field;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function field(): string { return $this->field; }

    /**
     * @return string
     */
    public function message(): string { return $this->message; }
}
