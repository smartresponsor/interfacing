<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\ValueObject;

final class InterfaceTenantId
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);
        if ('' === $value) {
            throw new \InvalidArgumentException('InterfaceTenantId must not be empty.');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
