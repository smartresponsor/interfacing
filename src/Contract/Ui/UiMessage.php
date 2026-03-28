<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Contract\Ui;

final readonly class UiMessage implements UiMessageInterface
{
    public function __construct(
        private string $type,
        private string $text,
        private ?string $code = null,
    ) {
        if ('' === $type) {
            throw new \InvalidArgumentException('UiMessage type must not be empty.');
        }
        if ('' === $text) {
            throw new \InvalidArgumentException('UiMessage text must not be empty.');
        }
    }

    public function type(): string
    {
        return $this->type;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function code(): ?string
    {
        return $this->code;
    }

    /** @return array{type: string, text: string, code: string|null} */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'text' => $this->text,
            'code' => $this->code,
        ];
    }

    /** @param array<string, mixed> $row */
    public static function fromArray(array $row): self
    {
        return new self(
            isset($row['type']) ? (string) $row['type'] : 'info',
            isset($row['text']) ? (string) $row['text'] : '',
            isset($row['code']) ? (string) $row['code'] : null,
        );
    }
}
