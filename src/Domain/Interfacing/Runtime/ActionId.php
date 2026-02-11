<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Runtime;

final class ActionId
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);
        if ($value === '') {
            throw new \InvalidArgumentException('ActionId must not be empty.');
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
