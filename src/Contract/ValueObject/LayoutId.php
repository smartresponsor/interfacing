<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\ValueObject;

final readonly class LayoutId implements LayoutIdInterface
{
    public function __construct(private string $value)
    {
        $this->assert($value);
    }

    public static function of(string $value): self
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

    private function assert(string $value): void
    {
        if ('' === $value) {
            throw new \InvalidArgumentException('LayoutId must not be empty.');
        }
        if (!preg_match('/^[a-z0-9][a-z0-9_\-\.]*$/', $value)) {
            throw new \InvalidArgumentException('LayoutId must be url-safe.');
        }
    }
}
