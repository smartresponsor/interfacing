<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Domain\Interfacing\Error;

/**
 *
 */

/**
 *
 */
final readonly class UiError
{
    /**
     * @param string $code
     * @param string $message
     * @param string|null $field
     */
    public function __construct(
        private string  $code,
        private string  $message,
        private ?string $field = null
    ) {
        $c = trim($this->code);
        if ($c === '' || strlen($c) > 64) {
            throw new \InvalidArgumentException('Invalid error code.');
        }
        $m = trim($this->message);
        if ($m === '' || strlen($m) > 500) {
            throw new \InvalidArgumentException('Invalid error message.');
        }
        $this->code = $c;
        $this->message = $m;
    }

    /**
     * @return string
     */
    public function code(): string { return $this->code; }

    /**
     * @return string
     */
    public function message(): string { return $this->message; }

    /**
     * @return string|null
     */
    public function field(): ?string { return $this->field; }
}
