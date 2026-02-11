<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model;

use App\DomainInterface\Interfacing\Model\UiStateInterface;

/**
 *
 */

/**
 *
 */
final class UiState implements UiStateInterface, \JsonSerializable
{
    /**
     * @param array $value
     */
    public function __construct(private readonly array $value = [])
    {
    }

    public static function empty(): self
    {
        return new self([]);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function with(string $key, mixed $value): self
    {
        $next = $this->value;
        $next[$key] = $value;

        return new self($next);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->value[$key] ?? $default;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
}
