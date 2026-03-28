<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Contract\Ui;

final readonly class UiError implements UiErrorInterface
{
    public function __construct(
        private string $scope,
        private ?string $path,
        private string $text,
        private ?string $code = null,
    ) {
        if ('' === $scope) {
            throw new \InvalidArgumentException('UiError scope must not be empty.');
        }
        if ('' === $text) {
            throw new \InvalidArgumentException('UiError text must not be empty.');
        }
    }

    public function scope(): string
    {
        return $this->scope;
    }

    public function path(): ?string
    {
        return $this->path;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function code(): ?string
    {
        return $this->code;
    }

    /**
     * @return array{scope: string, path: string|null, text: string, code: string|null}
     */
    public function toArray(): array
    {
        return [
            'scope' => $this->scope,
            'path' => $this->path,
            'text' => $this->text,
            'code' => $this->code,
        ];
    }
}
