<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Domain\Interfacing\Model;

final class ActionResult
{
    /** @param list<UiMessage> $message @param array<string,mixed> $data */
    private function __construct(
        private bool $ok,
        private ?UiErrorBag $error,
        private array $message,
        private array $data,
        private ?string $redirectTo
    ) {}

    /** @param list<UiMessage> $message @param array<string,mixed> $data */
    public static function ok(array $message = [], array $data = []): self
    {
        return new self(true, null, $message, $data, null);
    }

    /** @param list<UiMessage> $message @param array<string,mixed> $data */
    public static function validationError(UiErrorBag $error, array $message = [], array $data = []): self
    {
        return new self(false, $error, $message, $data, null);
    }

    /** @param list<UiMessage> $message @param array<string,mixed> $data */
    public static function domainError(array $message, array $data = []): self
    {
        return new self(false, null, $message, $data, null);
    }

    public function isOk(): bool { return $this->ok; }
    public function error(): ?UiErrorBag { return $this->error; }
    /** @return list<UiMessage> */
    public function messageList(): array { return $this->message; }
    /** @return array<string,mixed> */
    public function data(): array { return $this->data; }
    public function redirectTo(): ?string { return $this->redirectTo; }
}
