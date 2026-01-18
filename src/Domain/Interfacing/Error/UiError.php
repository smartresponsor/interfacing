<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Domain\Interfacing\Error;

final class UiError
{
    public function __construct(
        private readonly string $code,
        private readonly string $message,
        private readonly ?string $field = null
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

    public function code(): string { return $this->code; }
    public function message(): string { return $this->message; }
    public function field(): ?string { return $this->field; }
}
