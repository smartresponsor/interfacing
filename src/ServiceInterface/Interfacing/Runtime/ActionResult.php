<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Runtime;

final readonly class ActionResult
{
    public const TYPE_OK = 'ok';
    public const TYPE_VALIDATION_ERROR = 'validation-error';
    public const TYPE_DOMAIN_ERROR = 'domain-error';
    public const TYPE_REDIRECT = 'redirect';
    public const TYPE_RELOAD = 'reload';

    /** @param array<string, mixed> $data */
    private function __construct(
        public string $type,
        public array $data = [],
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function ok(array $data = []): self
    {
        return new self(self::TYPE_OK, $data);
    }

    /** @param array<string, string> $error */
    public static function validationError(array $error, array $globalError = []): self
    {
        return new self(self::TYPE_VALIDATION_ERROR, [
            'fieldError' => $error,
            'globalError' => $globalError,
        ]);
    }

    public static function domainError(string $message): self
    {
        return new self(self::TYPE_DOMAIN_ERROR, ['message' => $message]);
    }

    public static function redirect(string $url): self
    {
        return new self(self::TYPE_REDIRECT, ['url' => $url]);
    }

    public static function reload(): self
    {
        return new self(self::TYPE_RELOAD, []);
    }

    public function payload(): array
    {
        return $this->data;
    }

    public function type(): string
    {
        return $this->type;
    }
}
