<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Domain\Interfacing\Model;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\UiStateInterface;

final class UiState implements UiStateInterface
{
    /** @var array<string,mixed> */
    private array $value;

    /**
     * @param array<string,mixed> $value
     */
    private function __construct(array $value)
    {
        $this->value = $value;
    }

    /**
     * @param array<string,mixed> $value
     */
    public static function fromArray(array $value): self
    {
        return new self($value);
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return $this->value;
    }

    public function isEmpty(): bool
    {
        return $this->value === [];
    }
}
