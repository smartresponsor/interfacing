<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Form;

/**
 *
 */

/**
 *
 */
final class FormSubmitResult
{
    /**
     * @param array<string,string> $fieldError
     * @param array<string,mixed> $value
     */
    public function __construct(
        private readonly bool   $ok,
        private readonly string $message,
        private readonly array  $fieldError = [],
        private readonly array  $value = [],
    ) {
    }

    /**
     * @return bool
     */
    public function ok(): bool { return $this->ok; }

    /**
     * @return string
     */
    public function message(): string { return $this->message; }

    /** @return array<string,string> */
    public function fieldError(): array { return $this->fieldError; }

    /** @return array<string,mixed> */
    public function value(): array { return $this->value; }
}
