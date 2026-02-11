<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Error;

use RuntimeException;

/**
 *
 */

/**
 *
 */
final class DomainOperationFailed extends RuntimeException
{
    /** @var array<string, string> */
    private array $fieldMessage = [];

    /** @param array<string, string> $fieldMessage */
    public function __construct(string $message, array $fieldMessage = [], int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->fieldMessage = $fieldMessage;
    }

    /** @return array<string, string> */
    public function fieldMessage(): array
    {
        return $this->fieldMessage;
    }
}
