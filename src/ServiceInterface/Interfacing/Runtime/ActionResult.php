<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\ServiceInterface\Interfacing\Runtime;

    final class ActionResult
{
    /**
     * @param array<string, mixed> $data
     */
    private function __construct(
        public readonly string $type,
        public readonly array $data = [],
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function ok(array $data = []): self
    {
        return new self('ok', $data);
    }

    /**
     * @param array<string, string> $error
     */
    public static function validationError(array $error): self
    {
        return new self('validation-error', ['error' => $error]);
    }

    public static function domainError(string $message): self
    {
        return new self('domain-error', ['message' => $message]);
    }

    public static function redirect(string $url): self
    {
        return new self('redirect', ['url' => $url]);
    }
}

