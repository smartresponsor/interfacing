<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Runtime;

/**
 *
 */

/**
 *
 */
final class TenantId
{
    private string $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $value = trim($value);
        if ($value === '') {
            throw new \InvalidArgumentException('TenantId must not be empty.');
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
