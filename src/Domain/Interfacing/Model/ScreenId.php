<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Domain\Interfacing\Model;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface;

final class ScreenId implements ScreenIdInterface
{
    private function __construct(private string $value) {}

    public static function fromString(string $value): self
    {
        $value = trim($value);
        if ($value === '') {
            throw new \InvalidArgumentException('ScreenId must be non-empty.');
        }

        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
