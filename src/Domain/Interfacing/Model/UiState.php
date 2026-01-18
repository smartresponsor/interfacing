<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model;

use App\DomainInterface\Interfacing\Model\UiStateInterface;

final class UiState implements UiStateInterface, \JsonSerializable
{
    public function __construct(private array $value = [])
    {
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public function with(string $key, mixed $value): self
    {
        $next = $this->value;
        $next[$key] = $value;

        return new self($next);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->value[$key] ?? $default;
    }

    public function toArray(): array
    {
        return $this->value;
    }

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
}
