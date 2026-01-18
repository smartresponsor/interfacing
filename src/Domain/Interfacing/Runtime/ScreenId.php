<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\Domain\Interfacing\Runtime;

final class ScreenId
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);
        if ($value === '') {
            throw new \InvalidArgumentException('ScreenId must not be empty.');
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
