<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\ValueObject;

final readonly class ActionId implements ActionIdInterface
{
    private string $value;

    private function __construct(string $value)
    {
        $value = trim($value);
        if ('' === $value || !preg_match('/^[a-z0-9][a-z0-9\-\.]{1,127}$/', $value)) {
            throw new \InvalidArgumentException('Invalid action id.');
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

    public function equals(ActionIdInterface $other): bool
    {
        return $this->value === $other->toString();
    }
}
