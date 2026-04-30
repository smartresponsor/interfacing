<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\ValueObject;

final readonly class ScreenId implements ScreenIdInterface
{
    private string $value;

    private function __construct(string $value)
    {
        $value = trim($value);
        if ('' === $value || !preg_match('/^[a-z0-9][a-z0-9_\-\.]*$/', $value)) {
            throw new \InvalidArgumentException('Invalid screen id.');
        }

        $this->value = $value;
    }

    public static function of(string $value): self
    {
        return new self($value);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(ScreenIdInterface $other): bool
    {
        return $this->value === $other->toString();
    }
}
