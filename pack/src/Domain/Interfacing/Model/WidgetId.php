<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\Domain\Interfacing\Model;

use App\DomainInterface\Interfacing\Model\WidgetIdInterface;

final class WidgetId implements WidgetIdInterface
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
            throw new \InvalidArgumentException('WidgetId must not be empty.');
        }
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value)) {
            throw new \InvalidArgumentException('WidgetId must match slug format: lowercase words separated by single hyphen.');
        }
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(WidgetIdInterface $other): bool
    {
        return $this->value === $other->toString();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
