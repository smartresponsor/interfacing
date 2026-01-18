<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\Domain\Interfacing\Model;

use App\DomainInterface\Interfacing\Model\ScreenIdInterface;

final class ScreenId implements ScreenIdInterface
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        $value = trim($value);
        if ($value === '') {
            throw new \InvalidArgumentException('ScreenId must not be empty.');
        }
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value)) {
            throw new \InvalidArgumentException('ScreenId must match slug format: lowercase words separated by single hyphen.');
        }
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(ScreenIdInterface $other): bool
    {
        return $this->value === $other->toString();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
