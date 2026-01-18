    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Domain\Interfacing\Model\Action;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Action\ActionResultInterface;

final class ActionResult implements ActionResultInterface
{
    public const TYPE_OK = 'ok';
    public const TYPE_VALIDATION_ERROR = 'validation_error';
    public const TYPE_DOMAIN_ERROR = 'domain_error';
    public const TYPE_REDIRECT = 'redirect';
    public const TYPE_RELOAD = 'reload';

    /** @param array<string, mixed> $payload */
    private function __construct(
        private readonly string $type,
        private readonly array $payload,
    ) {}

    /** @param array<string, mixed> $patch */
    public static function ok(array $patch = [], array $flash = []): self
    {
        return new self(self::TYPE_OK, [
            'patch' => $patch,
            'flash' => $flash,
        ]);
    }

    /** @param array<string, string> $fieldError */
    public static function validationError(array $fieldError = [], array $globalError = []): self
    {
        return new self(self::TYPE_VALIDATION_ERROR, [
            'fieldError' => $fieldError,
            'globalError' => $globalError,
        ]);
    }

    public static function domainError(string $code, string $message): self
    {
        return new self(self::TYPE_DOMAIN_ERROR, [
            'code' => $code,
            'message' => $message,
        ]);
    }

    public static function redirect(string $url): self
    {
        return new self(self::TYPE_REDIRECT, [
            'url' => $url,
        ]);
    }

    public static function reload(): self
    {
        return new self(self::TYPE_RELOAD, []);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function payload(): array
    {
        return $this->payload;
    }
}

